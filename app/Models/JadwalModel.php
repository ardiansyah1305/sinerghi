<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'pegawai_id', 'tanggal_kerja', 'jenis_alokasi', 'usulan_id', 'status_approval'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getTodaySchedule($pegawaiId)
    {
        $today = date('Y-m-d');
        return $this->where([
            'pegawai_id' => $pegawaiId,
            'tanggal_kerja' => $today
        ])->first();
    }
}
