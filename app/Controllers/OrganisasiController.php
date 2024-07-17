<?php

namespace App\Controllers;

class OrganisasiController extends BaseController
{
    public function index()
    {
        // Pass data username ke view
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('organisasi/organisasi', $data);
    }
}
