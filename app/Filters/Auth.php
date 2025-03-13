<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        helper('auth_sso');

        if (!$session->get('logged_in')) {
            // If this is the login page or SSO callback, allow access
            $uri = $request->getUri();
            $path = $uri->getPath();
            
            // Allow access to login and callback routes without authentication
            $allowedPaths = ['/login', '/sso/callback'];
            if (in_array($path, $allowedPaths) || preg_match('#^/sso/callback(\?.*)?$#', $path)) {
                return;
            }
            
            // Always redirect to SSO login
            try {
                // Generate SSO token and request ID
                $token = generateToken();
                $requestId = generateRequestId($token);
                
                if ($requestId) {
                    $ssoUrl = rtrim(getenv('SSO_URL'), '/');
                    $loginUrl = ltrim(getenv('SSO_LOGIN_URL'), '/');
                    return redirect()->to($ssoUrl . '/' . $loginUrl . $requestId);
                }
            } catch (\Exception $e) {
                log_message('error', 'SSO Redirect Error: ' . $e->getMessage());
            }
            
            // If SSO redirect fails, redirect to login which will try SSO again
            return redirect()->to('/login');
        }

        // Verify SSO session if exists
        if ($session->get('sso_session')) {
            try {
                if (!verifyToken($session->get('sso_session'))) {
                    $session->destroy();
                    return redirect()->to('/login');
                }
            } catch (\Exception $e) {
                log_message('error', 'SSO Token Verification Error: ' . $e->getMessage());
                // If verification fails due to connection issues, continue with the session
                // This prevents users from being logged out when SSO server is temporarily unavailable
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
