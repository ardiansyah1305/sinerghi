<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingUserFields extends Migration
{
    public function up()
    {
        // Add name field if it doesn't exist
        if (!$this->db->fieldExists('name', 'users')) {
            $this->forge->addColumn('users', [
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'username_ldap'
                ]
            ]);
        }

        // Add email field if it doesn't exist
        if (!$this->db->fieldExists('email', 'users')) {
            $this->forge->addColumn('users', [
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'name'
                ]
            ]);
        }

        // Add is_active field if it doesn't exist
        if (!$this->db->fieldExists('is_active', 'users')) {
            $this->forge->addColumn('users', [
                'is_active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1,
                    'after' => 'role_id'
                ]
            ]);
        }
    }

    public function down()
    {
        // Remove fields if they exist
        if ($this->db->fieldExists('name', 'users')) {
            $this->forge->dropColumn('users', 'name');
        }
        if ($this->db->fieldExists('email', 'users')) {
            $this->forge->dropColumn('users', 'email');
        }
        if ($this->db->fieldExists('is_active', 'users')) {
            $this->forge->dropColumn('users', 'is_active');
        }
    }
}
