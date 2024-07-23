<?php

namespace App\Controllers;

use App\Models\UserModel;

class LayananController extends BaseController
{
    public function index()
    {
        // Pass data username ke view
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('layanan/layanan', $data);
    }
}
