<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ReferensiController extends Controller
{
    public function index()
    {
        // Mulai session
        $session = session();

        // Pastikan pengguna sudah login
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

        // Pass data username dan konten ke view
        $data = [
            'username' => $userData['username'],
            'contents' => $this->getContents() // Metode untuk mendapatkan konten
        ];

        // Tampilkan view dengan data yang diperlukan
        echo view('referensi/referensi', $data);
    }

    private function getContents()
    {
        return [
            'content1' => [
                [
                    'title' => 'Surat Keputusan Bersama Nomor 236, 1, 2 Tahun 2024',
                    'description' => 'SKB Perubahan tentang Hari Libur Nasional dan Cuti Bersama 2024',
                    'meta' => 'PMK Lainnya',
                    'date' => '2024-02-26',
                    'file' => 'path_to_pdf1.pdf'
                ],
                [
                    'title' => 'Surat Keputusan Bersama Nomor 237, 3, 4 Tahun 2024',
                    'description' => 'SKB Perubahan tentang Hari Libur Nasional dan Cuti Bersama 2024',
                    'meta' => 'PMK Lainnya',
                    'date' => '2024-03-26',
                    'file' => 'path_to_pdf2.pdf'
                ],
                [
                    'title' => 'Surat Keputusan Bersama Nomor 238, 5, 6 Tahun 2024',
                    'description' => 'SKB Perubahan tentang Hari Libur Nasional dan Cuti Bersama 2024',
                    'meta' => 'PMK Lainnya',
                    'date' => '2024-04-26',
                    'file' => 'path_to_pdf3.pdf'
                ],
                [
                    'title' => 'Surat Keputusan Bersama Nomor 239, 7, 8 Tahun 2024',
                    'description' => 'SKB Perubahan tentang Hari Libur Nasional dan Cuti Bersama 2024',
                    'meta' => 'PMK Lainnya',
                    'date' => '2024-05-26',
                    'file' => 'path_to_pdf4.pdf'
                ]
            ],
            'content2' => [
                [
                    'title' => 'Surat Keputusan Bersama Nomor 855, 3, 4 Tahun 2023',
                    'description' => 'SKB Hari Libur Nasional dan Cuti Bersama 2023',
                    'meta' => 'PMK Lainnya',
                    'date' => '2023-09-12',
                    'file' => 'path_to_pdf5.pdf'
                ],
                [
                    'title' => 'Surat Keputusan Bersama Nomor 856, 5, 6 Tahun 2023',
                    'description' => 'SKB Hari Libur Nasional dan Cuti Bersama 2023',
                    'meta' => 'PMK Lainnya',
                    'date' => '2023-10-12',
                    'file' => 'path_to_pdf6.pdf'
                ],
                [
                    'title' => 'Surat Keputusan Bersama Nomor 857, 7, 8 Tahun 2023',
                    'description' => 'SKB Hari Libur Nasional dan Cuti Bersama 2023',
                    'meta' => 'PMK Lainnya',
                    'date' => '2023-11-12',
                    'file' => 'path_to_pdf7.pdf'
                ]
            ],
            'content3' => [
                [
                    'title' => 'Judul Dokumen 1',
                    'description' => 'Deskripsi dokumen 1',
                    'meta' => 'PMK Lainnya',
                    'date' => '2023-01-01',
                    'file' => 'path_to_pdf9.pdf'
                ],
                [
                    'title' => 'Judul Dokumen 2',
                    'description' => 'Deskripsi dokumen 2',
                    'meta' => 'PMK Lainnya',
                    'date' => '2023-02-02',
                    'file' => 'path_to_pdf10.pdf'
                ]
            ],
            'content4' => [
                [
                    'title' => 'Pengembangan Infrastruktur dan Teknologi 1',
                    'description' => 'Deskripsi dokumen 1',
                    'meta' => 'Infrastruktur dan Teknologi',
                    'date' => '2023-05-05',
                    'file' => 'path_to_pdf13.pdf'
                ],
                [
                    'title' => 'Pengembangan Infrastruktur dan Teknologi 2',
                    'description' => 'Deskripsi dokumen 2',
                    'meta' => 'Infrastruktur dan Teknologi',
                    'date' => '2023-06-06',
                    'file' => 'path_to_pdf14.pdf'
                ],
                [
                    'title' => 'Pengembangan Infrastruktur dan Teknologi 3',
                    'description' => 'Deskripsi dokumen 3',
                    'meta' => 'Infrastruktur dan Teknologi',
                    'date' => '2023-07-07',
                    'file' => 'path_to_pdf15.pdf'
                ]
            ]
        ];
    }
}
