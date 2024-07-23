<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        $data = [
            'nip' => $session->get('nip'),
        ];

        echo view('dashboard/dashboard', $data);
    }
}
