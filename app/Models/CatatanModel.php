<?php

namespace App\Models;

use CodeIgniter\Model;

class CatatanModel extends Model
{
    protected $table = 'catatan_usulan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usulan_id', 'catatan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'usulan_id' => 'required|numeric',
        'catatan' => 'required'
    ];
    protected $validationMessages = [
        'usulan_id' => [
            'required' => 'ID Usulan harus diisi',
            'numeric' => 'ID Usulan harus berupa angka'
        ],
        'catatan' => [
            'required' => 'Catatan harus diisi'
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
