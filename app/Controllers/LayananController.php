<?php

namespace App\Controllers;

use App\Models\LayananModel;
use App\Models\LayananKategoriModel;

class LayananController extends BaseController
{
    protected $layananModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
        $this->kategoriModel = new LayananKategoriModel();
    }

    public function index()
    {
        // Ambil data layanan dari database dengan join ke kategori
        $layanan = $this->layananModel
            ->select('layanan.*, layanan_kategori.name as kategori_name')
            ->join('layanan_kategori', 'layanan.kategori_id = layanan_kategori.id')
            ->findAll();

        // Pass data layanan dan user ke view
        $data = [
            'nip' => $this->userData['nip'],
            'layanan' => $layanan
        ];

        echo view('layanan/layanan', $data);
    }
}
