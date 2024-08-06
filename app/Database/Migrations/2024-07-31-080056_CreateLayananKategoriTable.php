<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayananKategoriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('layanan_kategori');

        // Insert default categories
        $data = [
            ['name' => 'Layanan ASN'],
            ['name' => 'Administrasi Layanan ASN'],
            ['name' => 'Layanan IT'],
        ];

        $db = \Config\Database::connect();
        $builder = $db->table('layanan_kategori');
        $builder->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('layanan_kategori');
    }
}
