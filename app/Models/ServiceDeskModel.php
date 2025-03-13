<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceDeskModel extends Model
{
    protected $table            = 'tiket';
    protected $primaryKey = 'id';
    protected $allowedFields    = [
        'kode_tiket', 
        'id_pegawai', 
        'id_unit_kerja', 
        'id_layanan', 
        'id_pegawai_penerima_tugas', 
        'status', 
        'tanggal_status_terkini', 
        'lampiran', 'deskripsi', 
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    protected $useTimestamps    = true;
}
