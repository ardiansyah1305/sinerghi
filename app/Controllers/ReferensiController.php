<?php

namespace App\Controllers;

class ReferensiController extends BaseController
{
    public function index()
    {
        // Pass data username dan konten ke view
        $data = [
            'username' => $this->userData['username'],
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
                    'title' => 'Surat Kepmenko PMK No. 7 Tahun 2024 - Tim Evaluator RB',
                    'description' => 'Berisikan Perpres Grand Design',
                    'meta' => 'KemenPANRB dan KPMK',
                    'date' => '2024-02-26',
                    'file' => 'uploads/pdf/Kepmenko PMK No. 7 Tahun 2024 - Tim Evaluator RB.pdf'
                ],
                [
                    'title' => 'Surat Keputusan Bersama Nomor 237, 3, 4 Tahun 2024',
                    'description' => 'SKB Perubahan tentang Hari Libur Nasional dan Cuti Bersama 2024',
                    'meta' => 'PMK Lainnya',
                    'date' => '2024-03-26',
                    'file' => 'uploads/pdf/Kepmenko PMK No. 7 Tahun 2024 - Tim Evaluator RB.pdf'
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
