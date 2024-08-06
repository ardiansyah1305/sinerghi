<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kategori_id', 'title', 'links', 'color', 'icon'];
    protected $useTimestamps = true;

    public function getAllLayanan()
    {
        return $this->select('layanan.*, layanan_kategori.name as kategori_name')
                    ->join('layanan_kategori', 'layanan_kategori.id = layanan.kategori_id')
                    ->findAll();
    }
}
