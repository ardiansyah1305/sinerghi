<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Jika user belum login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Redirect berdasarkan role_id
        $role_id = $session->get('role_id');
        $currentPath = $request->uri->getPath();

        if ($role_id == '1' && !str_starts_with($currentPath, 'admin')) {
            return redirect()->to('/admin/dashboard');
        } elseif ($role_id == '2' && !str_starts_with($currentPath, 'pegawai')) {
            return redirect()->to('/pegawai/dashboard');
        } elseif ($role_id == '3' && $currentPath !== 'dashboard') {
            return redirect()->to('/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
