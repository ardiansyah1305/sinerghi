<?php

namespace App\Models;

use CodeIgniter\Model;

class EselonModel extends Model
{
    protected $table = 'eselon';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_eselon', 'kode'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}
