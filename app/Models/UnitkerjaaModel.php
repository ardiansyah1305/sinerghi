<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitkerjaaModel extends Model
{
    protected $table = 'unit_kerjaa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_unit_kerjaa', 'parent_id', 'unit_kerja_id'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllUnitkerja()
{
    return $this->select('unit_kerjaa.*, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama')
        ->join('unit_kerja', 'unit_kerjaa.unit_kerja_id = unit_kerja.id')
        ->findAll(); // Add pagination here
}
}
