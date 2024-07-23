<?php

namespace App\Controllers;

class PengumumanController extends BaseController
{
    public function detail_pengumuman1()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('dashboard/detail_pengumuman1', $data);
    }

    public function detail_pengumuman2()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('dashboard/detail_pengumuman2', $data);
    }

    public function detail_pengumuman3()
    {
        $data = [
            'nip' => $this->userData['nip']
        ];

        echo view('dashboard/detail_pengumuman3', $data);
    }
}
