<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananKategoriModel extends Model
{
    protected $table = 'layanan_kategori';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'created_at', 'updated_at'];
    protected $useTimestamps = false;
}
