<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLdapUsername extends Migration
{
    public function up()
    {
        // Check if username_ldap column exists
        if (!$this->db->fieldExists('username_ldap', 'users')) {
            $this->forge->addColumn('users', [
                'username_ldap' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'pegawai_id'
                ]
            ]);

            // Add index for faster lookups
            $this->forge->addKey('username_ldap', false, true);
        }
    }

    public function down()
    {
        // Remove username_ldap column if it exists
        if ($this->db->fieldExists('username_ldap', 'users')) {
            $this->forge->dropColumn('users', 'username_ldap');
        }
    }
}
