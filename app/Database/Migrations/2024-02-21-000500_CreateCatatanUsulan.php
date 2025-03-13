<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatatanUsulan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'usulan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usulan_id', 'usulan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('catatan_usulan');
    }

    public function down()
    {
        $this->forge->dropTable('catatan_usulan');
    }
}
