<?php

namespace App\Models;

use CodeIgniter\Model;

class JenjangpangkatModel extends Model
{
    protected $table = 'jenjang_pangkat';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_pangkat', 'kode','golongan', 'ruang'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}