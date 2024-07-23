<?php

namespace App\Controllers;

use App\Models\UserModel;

class LayananController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Ambil user_id dari session
        $userId = $session->get('id');
        if (!$userId) {
            log_message('error', 'User ID not found in session.');
            return redirect()->to('/login'); // Arahkan ke halaman login jika user_id tidak ditemukan
        }

        // Pass data username ke view
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('layanan/layanan', $data);
    }
}
