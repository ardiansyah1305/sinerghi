<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LdapAuthController extends BaseController
{
    protected $session;
    protected $ldapConfig;
    protected $userModel;

    public function __construct()
    {
        $this->session = session();
        $this->ldapConfig = config('Ldap');
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if ($this->session->get('logged_in')) {
            return $this->redirectBasedOnRole($this->session->get('role_id'));
        }
        
        return view('auth/ldap_login');
    }

    public function login()
    {
        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if (empty($username) || empty($password)) {
                throw new \Exception('Username dan password harus diisi');
            }

            // First check if user exists in local database
            $userData = $this->userModel->where('username_ldap', $username)->first();
            if (!$userData) {
                throw new \Exception('User tidak terdaftar dalam sistem. Silahkan hubungi administrator.');
            }

            // Connect to LDAP server
            $ldapConn = ldap_connect($this->ldapConfig->host, $this->ldapConfig->port);
            if (!$ldapConn) {
                throw new \Exception('Tidak dapat terhubung ke server LDAP');
            }

            // Set LDAP options
            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

            // First try to bind with admin credentials
            $adminBind = @ldap_bind($ldapConn, $this->ldapConfig->adminDn, $this->ldapConfig->adminPassword);
            if (!$adminBind) {
                throw new \Exception('Gagal otentikasi dengan LDAP');
            }

            // Search for the user
            $filter = sprintf($this->ldapConfig->userFilter, $username, $username);
            $result = ldap_search($ldapConn, $this->ldapConfig->userDn, $filter);
            
            if (!$result) {
                throw new \Exception('User tidak ditemukan di LDAP');
            }

            $entries = ldap_get_entries($ldapConn, $result);
            if ($entries['count'] === 0) {
                throw new \Exception('User tidak ditemukan di LDAP');
            }

            // Get user's DN
            $userDn = $entries[0]['dn'];

            // Try to bind with user credentials
            $userBind = @ldap_bind($ldapConn, $userDn, $password);
            if (!$userBind) {
                throw new \Exception('Username atau password salah');
            }

            // Check if user is active
            if (!$userData['is_active']) {
                throw new \Exception('Akun Anda tidak aktif. Silahkan hubungi administrator.');
            }

            // Set session data
            $sessionData = [
                'user_id' => $userData['id'],
                'username' => $userData['username_ldap'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'role_id' => $userData['role_id'],
                'pegawai_id' => $userData['pegawai_id'],
                'logged_in' => true
            ];
            $this->session->set($sessionData);

            // Close LDAP connection
            ldap_close($ldapConn);

            // Redirect based on role
            return $this->redirectBasedOnRole($userData['role_id']);

        } catch (\Exception $e) {
            $this->session->setFlashdata('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

    private function redirectBasedOnRole($roleId)
    {
        switch ($roleId) {
            case '1':
                return redirect()->to('/admin/dashboard');
            case '2':
                return redirect()->to('/pegawai/dashboard');
            default:
                return redirect()->to('/dashboard');
        }
    }
}
