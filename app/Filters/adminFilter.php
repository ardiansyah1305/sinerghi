<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Mendapatkan session
        $session = session();

        // Memeriksa apakah pengguna sudah login dan memiliki peran '1'
        if (!$session->get('logged_in') || $session->get('role') != '1') {
            // Jika tidak, arahkan ke halaman login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tambahkan logika setelah request di sini jika diperlukan
    }
}
