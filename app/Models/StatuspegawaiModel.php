<?php

namespace App\Models;

use CodeIgniter\Model;

class StatuspegawaiModel extends Model
{
    protected $table = 'status_pegawai';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_status', 'kode'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}