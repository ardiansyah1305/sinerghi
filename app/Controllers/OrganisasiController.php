<?php

namespace App\Controllers;

class OrganisasiController extends BaseController
{
    protected $userData;

    public function __construct()
    {
        // Inisialisasi data pengguna, misalnya dari sesi atau model
        $this->userData = [
            'nip' => session()->get('nip') // Contoh pengambilan data dari sesi
        ];
    }

    public function index()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/organisasi', $data);
    }

    public function deputi_satu()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/deputi_satu', $data);
    }

    public function deputi_dua()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/deputi_dua', $data);
    }

    public function deputi_tiga()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/deputi_tiga', $data);
    }

    public function deputi_empat()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/deputi_empat', $data);
    }

    public function deputi_lima()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/deputi_lima', $data);
    }

    public function deputi_enam()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('Organisasi/deputi_enam', $data);
    }
}