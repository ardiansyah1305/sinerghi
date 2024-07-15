<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class DashboardControllers extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login
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

        // Debugging: Periksa userId
        log_message('debug', 'User ID: ' . $userId);

        // Ambil data user dari database
        $userModel = new UserModel();
        $userData = $userModel->getUserById($userId);
        if (!$userData) {
            log_message('error', 'User not found in database for user ID: ' . $userId);
            return redirect()->to('/login')->with('error', 'User not found'); // Arahkan ke halaman login jika user tidak ditemukan
        }

        // Debugging: Periksa data pengguna
        log_message('debug', 'User Data: ' . print_r($userData, true));

        // Pass data username ke view
        $data = [
            'username' => $userData['username']
        ];

        // Load template dan pass data
        echo view('dashboard/dashboard', $data);
    }
}
