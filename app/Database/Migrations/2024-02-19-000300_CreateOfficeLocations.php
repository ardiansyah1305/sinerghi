<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOfficeLocations extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,7',
                'null' => false,
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,7',
                'null' => false,
            ],
            'radius' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'comment' => 'Radius in meters',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('office_locations');

        // Insert the predefined locations
        $data = [
            [
                'name' => 'Lokasi 1',
                'latitude' => -6.1724005,
                'longitude' => 106.8198105,
                'radius' => 100,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Lokasi 2',
                'latitude' => -6.1712754,
                'longitude' => 106.8186743,
                'radius' => 100,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Lokasi 3',
                'latitude' => -6.2281918,
                'longitude' => 106.8150768,
                'radius' => 50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('office_locations')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('office_locations');
    }
}
