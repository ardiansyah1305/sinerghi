<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('pegawai/dashboard');
    }
}

