<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\CURLRequest;

class SSOAuthController extends BaseController
{
    protected $session;
    protected $userModel;
    protected $ssoConfig;

    public function __construct()
    {
        $this->session = session();
        $this->userModel = new UserModel();
        
        // Load SSO configuration
        $this->ssoConfig = config('SSO');
    }

    /**
     * Generate authentication token for SSO
     */
    private function generateToken()
    {
        $timestamp = time();
        $data = "{$this->ssoConfig['clientKey']}:{$timestamp}";
        $hmac = hash_hmac('sha256', $data, $this->ssoConfig['clientSecret']);
        
        return base64_encode("{$this->ssoConfig['clientKey']}:{$timestamp}:{$hmac}");
    }

    /**
     * Generate request ID from SSO server
     */
    private function generateRequestId($token)
    {
        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->request('POST', $this->ssoConfig['baseUrl'] . '/api/generate', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'client_id' => $this->ssoConfig['clientKey'],
                    'origin' => $this->ssoConfig['cookieDomain'],
                    'redirect_uri' => $this->ssoConfig['serverHost']
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            return $result['request_id'] ?? null;
        } catch (\Exception $e) {
            log_message('error', 'SSO Request ID Generation Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify SSO token
     */
    private function verifyToken($token)
    {
        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->request('POST', $this->ssoConfig['baseUrl'] . '/api/verify', [
                'json' => [
                    'token' => $token
                ]
            ]);
            
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            log_message('error', 'SSO Token Verification Error: ' . $e->getMessage());
            return ['valid' => false];
        }
    }

    /**
     * Handle AJAX token verification requests
     */
    public function verifyTokenAjax()
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        // Get token from request
        $token = $this->request->getJSON(true)['token'] ?? null;
        
        if (!$token) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token is required'
            ]);
        }
        
        // Verify token
        $verification = $this->verifyToken($token);
        
        if ($verification['valid']) {
            // Token is valid, check if user exists in local database
            $userData = $this->userModel->where('username_ldap', $verification['username'])->first();
            
            if (!$userData) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak terdaftar dalam sistem'
                ]);
            }
            
            // Set session data
            $sessionData = [
                'user_id' => $userData['id'],
                'username' => $userData['username_ldap'],
                'name' => $userData['name'] ?? $verification['name'] ?? '',
                'email' => $userData['email'] ?? $verification['email'] ?? '',
                'role_id' => $userData['role_id'],
                'pegawai_id' => $userData['pegawai_id'],
                'logged_in' => true
            ];
            $this->session->set($sessionData);
            
            // Set SSO cookie
            set_cookie('sso_session', $token, 3600, '', '/', '', true, true, 'Lax');
            
            // Determine redirect URL based on role
            $redirectUrl = '/dashboard';
            switch ($userData['role_id']) {
                case '1':
                    $redirectUrl = '/admin/dashboard';
                    break;
                case '2':
                    $redirectUrl = '/pegawai/dashboard';
                    break;
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Authentication successful',
                'redirect' => $redirectUrl
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid or expired token'
            ]);
        }
    }

    /**
     * Handle callback from SSO server with token
     */
    public function callback()
    {
        // Get token from query parameter
        $token = $this->request->getGet('token');
        
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Token tidak valid');
        }
        
        // Verify token
        $verification = $this->verifyToken($token);
        
        if ($verification['valid']) {
            // Token is valid, check if user exists in local database
            $userData = $this->userModel->where('username_ldap', $verification['username'])->first();
            
            if (!$userData) {
                return redirect()->to('/login')->with('error', 'User tidak terdaftar dalam sistem');
            }
            
            // Set session data
            $sessionData = [
                'id' => $userData['id'],
                'username' => $userData['username_ldap'],
                'name' => $userData['name'] ?? $verification['name'] ?? '',
                'email' => $userData['email'] ?? $verification['email'] ?? '',
                'role_id' => $userData['role_id'],
                'pegawai_id' => $userData['pegawai_id'],
                'logged_in' => true
            ];
            $this->session->set($sessionData);
            
            // Set SSO cookie
            set_cookie('sso_session', $token, 3600, '', '/', '', true, true, 'Lax');
            
            // Redirect based on role
            return $this->redirectBasedOnRole($userData['role_id']);
        } else {
            // Invalid token
            return redirect()->to('/login')->with('error', 'Token tidak valid atau telah kadaluarsa');
        }
    }

    /**
     * Login page
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole(session()->get('role_id'));
        }
        
        // Generate token for SSO authentication
        $token = $this->generateToken();
        
        // Generate request ID
        $requestId = $this->generateRequestId($token);
        
        if (!$requestId) {
            // Log error
            log_message('error', 'Failed to generate SSO request ID');
            // Redirect to regular login
            return redirect()->to('/login')->with('error', 'Gagal terhubung ke layanan SSO. Silakan coba lagi nanti.');
        }
        
        // Redirect to SSO login page
        return redirect()->to($this->ssoConfig['baseUrl'] . $this->ssoConfig['loginUrl'] . $requestId);
    }
    
    /**
     * Redirect based on role
     */
    private function redirectBasedOnRole($roleId)
    {
        switch ($roleId) {
            case '1':
            case '2':
            case '3':
                return redirect()->to('/dashboard');
            case '4':
                return redirect()->to('/dashboard');
            default:
                return redirect()->to('/login');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->destroy();
        delete_cookie('sso_session');
        return redirect()->to('/login');
    }
}
