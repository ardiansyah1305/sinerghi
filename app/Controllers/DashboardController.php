<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        $data = [
            'username' => $session->get('username'),
        ];

        echo view('dashboard/dashboard', $data);
    }
}
