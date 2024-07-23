<?php

namespace App\Controllers;

class OrganisasiController extends BaseController
{
    public function index()
    {
        // Pass data username ke view
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('organisasi/organisasi', $data);
    }
}
