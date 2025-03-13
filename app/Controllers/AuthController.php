<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Services;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        helper(['auth_sso', 'form']);
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $session = session();

        // If user is already logged in, redirect to dashboard
        if ($session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        // For local development, show regular login form instead of SSO
        // return view('auth/regular_login');

        try {
            // Generate SSO token and request ID
            $token = generateToken();
            $requestId = generateRequestId($token);

            if (!$requestId) {
                log_message('error', 'Failed to generate SSO request ID');
                // If we can't generate a request ID, show an error page
                return $this
                    ->response
                    ->setStatusCode(503)
                    ->setBody('<html><body><h1>SSO Service Unavailable</h1><p>The SSO service is currently unavailable. Please try again later or contact the administrator.</p><p><a href="/login">Try Again</a></p></body></html>');
            }

            // Store token in session temporarily
            $session->setTempdata('sso_temp_token', $token, 300);  // 5 minutes expiry

            // Redirect to SSO login page
            $ssoUrl = rtrim(getenv('SSO_URL'), '/');
            $loginUrl = ltrim(getenv('SSO_LOGIN_URL'), '/');
            return redirect()->to($ssoUrl . '/' . $loginUrl . $requestId);
        } catch (\Exception $e) {
            log_message('error', 'SSO Login Error: ' . $e->getMessage());
            // If there's an error, show an error page
            return $this
                ->response
                ->setStatusCode(503)
                ->setBody('<html><body><h1>SSO Service Error</h1><p>There was an error connecting to the SSO service. Please try again later or contact the administrator.</p><p><a href="/login">Try Again</a></p></body></html>');
        }
    }

    /**
     * Process regular login form submission
     */
    public function loginAuth()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // For local development, we'll use a simple authentication
        // You can modify this to use your actual authentication logic
        $user = $this->userModel->where('username_ldap', $username)->first();
        
        if ($user) {
            // For local development, use a simple password check
            // In production, you would use proper password hashing
            // This is just for demonstration purposes
            if ($password === 'password123' || $password === 'admin123') {
                // Set session data
                $ses_data = [
                    'id' => $user['id'],
                    'username' => $user['username_ldap'],
                    'pegawai_id' => $user['pegawai_id'],
                    'role_id' => $user['role_id'],
                    'logged_in' => true,
                    'last_activity' => time()
                ];
                $session->set($ses_data);
                
                // Check if this is an AJAX request
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Login berhasil',
                        'redirect' => site_url('/dashboard')
                    ]);
                }
                
                // Regular form submission redirect
                return redirect()->to('/dashboard');
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Password salah. Untuk pengembangan lokal, gunakan password: password123'
                    ])->setStatusCode(401);
                }
                
                return redirect()->to('/login')->with('error', 'Password salah. Untuk pengembangan lokal, gunakan password: password123');
            }
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Username tidak ditemukan'
                ])->setStatusCode(401);
            }
            
            return redirect()->to('/login')->with('error', 'Username tidak ditemukan');
        }
    }

    public function ssoCallback()
    {
        $session = session();

        // Check if token is in GET or POST parameters
        $token = $this->request->getGet('token') ?? $this->request->getPost('token');

        log_message('debug', 'SSO Callback received. Method: ' . $this->request->getMethod() . ', Token: ' . ($token ? 'present' : 'missing'));

        if (!$token) {
            log_message('error', 'SSO Callback: No token provided');
            return redirect()->to('/login');
        }

        try {
            // Get user data from SSO
            log_message('debug', 'SSO Callback: Attempting to get user data with token');
            $userData = getUserDataFromSSO($token);

            if (!$userData || !isset($userData['username'])) {
                log_message('error', 'SSO Callback: Invalid or missing user data from SSO');
                return redirect()->to('/login');
            }

            log_message('debug', 'SSO Callback: User data received: ' . json_encode($userData));

            // Find user in local database
            $localUser = $this->userModel->where('username_ldap', $userData['username'])->first();
            if (!$localUser) {
                log_message('error', 'SSO Callback: User not found in local database: ' . $userData['username']);
                return $this
                    ->response
                    ->setStatusCode(403)
                    ->setBody('<html><body><h1>Access Denied</h1><p>Your account is not registered in the system. Please contact the administrator.</p><p><a href="/login">Try Again</a></p></body></html>');
            }

            // Set session data
            $ses_data = [
                'id' => $localUser['id'],
                'username' => $localUser['username_ldap'],
                'pegawai_id' => $localUser['pegawai_id'],
                'role_id' => $localUser['role_id'],
                'logged_in' => true,
                'sso_session' => $token,
                'last_activity' => time()
            ];
            $session->set($ses_data);

            log_message('info', 'SSO Callback: User successfully logged in: ' . $localUser['username_ldap']);

            // Determine redirect URL based on role
            $redirectUrl = '/dashboard';
            if (!in_array($localUser['role_id'], ['1', '2', '3', '4'])) {
                log_message('error', 'SSO Callback: Invalid role for user: ' . $localUser['username_ldap'] . ', Role: ' . $localUser['role_id']);
                return $this
                    ->response
                    ->setStatusCode(403)
                    ->setBody('<html><body><h1>Access Denied</h1><p>Your account does not have the required permissions. Please contact the administrator.</p><p><a href="/login">Try Again</a></p></body></html>');
            }

            return redirect()->to($redirectUrl);
        } catch (\Exception $e) {
            log_message('error', 'SSO Callback Error: ' . $e->getMessage());
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        // For local development, just destroy the session
        // session()->destroy();
        // return redirect()->to('/login');
        
        // Original SSO logout - Temporarily disabled
        return ssoLogout();
    }

    /**
     * Check SSO server status
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function ssoStatus()
    {
        // For local development, always return unavailable
        // return $this->response->setJSON([
        //     'status' => 'error',
        //     'message' => 'SSO server disabled for local development',
        //     'url' => 'localhost'
        // ]);
        
        try {
            $ssoUrl = rtrim(getenv('SSO_IP_LOCAL') ?: getenv('SSO_URL'), '/');

            if (empty($ssoUrl)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'SSO URL not configured'
                ]);
            }

            // Create options array for curl
            $options = [
                'timeout' => 5,
                'connect_timeout' => 5,
                'verify' => false
            ];

            // Create a new CurlRequest with options
            $client = Services::curlrequest($options);

            // Make a simple HEAD request to check if the server is up
            $response = $client->request('HEAD', $ssoUrl, $options);

            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return $this->response->setJSON([
                    'status' => 'ok',
                    'message' => 'SSO server is available',
                    'url' => $ssoUrl
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'SSO server returned status code: ' . $response->getStatusCode(),
                    'url' => $ssoUrl
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'SSO server connection error: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'url' => $ssoUrl ?? 'Not configured'
            ]);
        }
    }
}
