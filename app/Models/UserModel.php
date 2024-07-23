<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nip', 'gelar_depan', 'nama', 'gelar_belakang', 'password', 
        'role', 'kode_bidang', 'status', 'jabatan_struktural'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
