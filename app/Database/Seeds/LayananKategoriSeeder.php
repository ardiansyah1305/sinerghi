<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Layanan ASN'],
            ['name' => 'Administrasi Layanan ASN'],
            ['name' => 'Layanan IT'],
        ];

        $this->db->table('layanan_kategori')->insertBatch($data);
    }
}
