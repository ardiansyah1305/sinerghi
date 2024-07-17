<?php

namespace App\Controllers;

class PengumumanController extends BaseController
{
    public function detail_pengumuman1()
    {
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('dashboard/detail_pengumuman1', $data);
    }

    public function detail_pengumuman2()
    {
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('dashboard/detail_pengumuman2', $data);
    }

    public function detail_pengumuman3()
    {
        $data = [
            'username' => $this->userData['username']
        ];

        echo view('dashboard/detail_pengumuman3', $data);
    }
}
