<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrasiFebruari extends Migration
{
    public function up()
    {
        // Sliders Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tipe_jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'eselon' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jabatan');
    }
    

    public function down()
    {
        
        $this->forge->dropTable('jabatan');
        
    }

}