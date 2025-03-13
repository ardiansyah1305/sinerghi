<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRemainingLdapFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'username_ldap'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'name'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'after' => 'role_id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['name', 'email', 'is_active']);
    }
}
