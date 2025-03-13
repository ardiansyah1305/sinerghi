<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'pegawai_id' => '1',
            'password' => password_hash('pmk12345', PASSWORD_DEFAULT), 
            'role_id' => '1'
        ];

        $this->db->table('users')->insert($data);
    }
}
