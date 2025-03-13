<?php

namespace App\Models;

use CodeIgniter\Model;

class HariLiburModel extends Model
{
    protected $table      = 'hari_libur';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['tanggal', 'tentang'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'tanggal' => 'required|valid_date',
        'tentang' => 'required'
    ];
    protected $validationMessages   = [
        'tanggal' => [
            'required' => 'Tanggal hari libur harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'tentang' => [
            'required' => 'Keterangan hari libur harus diisi'
        ]
    ];
    protected $skipValidation       = false;
}
