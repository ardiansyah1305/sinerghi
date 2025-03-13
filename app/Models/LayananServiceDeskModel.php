<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananServiceDeskModel extends Model
{
    protected $table            = 'layanan_servicedesk';
    protected $primaryKey = 'id';
    protected $allowedFields    = [
        'id_unit_kerja', 'jenis_layanan'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    
}
