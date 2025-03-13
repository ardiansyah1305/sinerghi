<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pegawai_id',
        'username_ldap',
        'name',
        'email',
        'username_ldap',
        'password',
        'role_id',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllUser()
    {
        return $this->select('users.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.pegawai_id = users.id', 'left')
            ->findAll();
    }

    public function getAllUserWithNama()
    {
        return $this->select('users.*, pegawai.nama as nama, pegawai.nip as nip')
            ->join('pegawai', 'users.pegawai_id = pegawai.id', 'left')
            ->findAll();
    }

    public function getAllUserWithNamaId($id)
    {
        return $this->select('users.*, pegawai.nama as nama, pegawai.nip as nip')
            ->join('pegawai', 'users.pegawai_id = pegawai.id', 'left')
            ->where('users.id', $id)
            ->first();
    }

    public function getUserLogin($nip)
    {
        return $this->select('users.*, pegawai.nama as nama, pegawai.nip as nip')
            ->join('pegawai', 'users.pegawai_id = pegawai.id', 'left')
            ->where('pegawai.nip', $nip)
            ->first();
    }

    public function getUserByLdapUsername($username)
    {
        return $this->where('username_ldap', $username)
                   ->first();
    }
}
