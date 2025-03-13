<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthSSO implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        $response = Services::response();
        helper('auth_sso');

        // Check if user has active session
        if (!$session->get('sso_session')) {
            $token = generateToken();
            $requestId = generateRequestId($token);
            
            if ($requestId) {
                return $response->redirect("https://sso.kemenkopmk.go.id" . getenv('SSO_LOGIN_URL') . $requestId);
            }
            // print_r($requestId);
            return $response->setStatusCode(500)
                           ->setJSON(['error' => 'Failed to generate SSO request']);
        }

        // Verify token with SSO server
        $isValid = verifyToken($session->get('sso_session'));
        if (!$isValid) {
            $session->remove('sso_session');
            $token = generateToken();
            $requestId = generateRequestId($token);
            
            if ($requestId) {
                return $response->redirect("https://sso.kemenkopmk.go.id" . getenv('SSO_LOGIN_URL') . $requestId);
            }
        }

        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after
    }
}
