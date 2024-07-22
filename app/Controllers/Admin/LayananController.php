<?php

namespace App\Controllers;

use App\Models\UserModel;

class LayananController extends BaseController
{
    public function index()
    {
        // Pass data username ke view
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('layanan/layanan', $data);
    }
}
