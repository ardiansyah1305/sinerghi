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
        // Show the coming soon page instead of the original functionality
        return view('layanan/index');
    }
}
