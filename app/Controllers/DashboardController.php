<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('dashboard/dashboard', $data);
    }
}




