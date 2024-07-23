<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
                'default'    => '0',
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '18',
                'default'    => '0',
            ],
            'gelar_depan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '0',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => '0',
            ],
            'gelar_belakang' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '0',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => '',
                'null'       => true,
                'default'    => '0',
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => '1',
                'default'    => '0',
                'default'    => '0',
            ],
            'kode_bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '0',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '0',
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '0',
            ],
            'jabatan_struktural' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '0',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
