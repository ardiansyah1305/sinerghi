<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class Auth extends Controller
{
    public function __construct()
    {
        helper('auth_sso');
    }

    public function index()
    {
        return redirect()->to('/');
    }

    public function callback()
    {
        $token = $this->request->getGet('token');
        
        if (!$token) {
            return redirect()->to('/')->with('error', 'No SSO token provided');
        }

        // Verify token
        if (verifyToken($token)) {
            $session = Services::session();
            $session->set('sso_session', $token);
            
            // You might want to fetch user data here and store it in session
            return redirect()->to('/')->with('success', 'Successfully logged in');
        }

        return redirect()->to('/')->with('error', 'Invalid SSO token');
    }

    public function logout()
    {
        $session = Services::session();
        $session->remove('sso_session');
        
        return redirect()->to('/');
    }
}
