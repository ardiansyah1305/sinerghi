<?php

namespace App\Models;

use CodeIgniter\Model;

class PenugasanModel extends Model
{
    protected $table            = 'usulan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'bulan',
        'upload_by', 
        'file_surat', 
        'catatan', 
        'status_approval',
        'catatan_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true; 

    public function getLatestUsulanByUnit($unit_kerja_id)
    {
        return $this->select('usulan.*, pegawai.unit_kerja_id')
                   ->join('pegawai', 'usulan.upload_by = pegawai.id')
                   ->where('pegawai.unit_kerja_id', $unit_kerja_id)
                   ->orderBy('usulan.created_at', 'DESC')
                   ->first();
    }

    public function getUsulanByUnit($unit_id)
    {
        $sessionPegawaiId = session('pegawai_id');
        $roleId = session('role_id');

        $query = $this->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama_unit_kerja as nama_unit')
            ->join('pegawai', 'pegawai.id = usulan.upload_by')
            ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id');

        // Filter berdasarkan role
        if ($roleId == 1 || $roleId == 2) {
            // Admin dan Kepala Unit dapat melihat semua usulan
            $query->where('unit_kerja.id', $unit_id);
        } elseif ($roleId == 3) {
            // Koordinator Unit
            $pegawaiModel = new \App\Models\PegawaiModel();
            $unitKerjaModel = new \App\Models\UnitkerjaModel();
            
            $pegawai = $pegawaiModel->find($sessionPegawaiId);
            $pegawaiUnitKerja = $unitKerjaModel->find($pegawai['unit_kerja_id']);
            
            if ($pegawaiUnitKerja && $pegawaiUnitKerja['parent_id'] == 2) {
                // Jika koordinator berada di unit kerja dengan parent_id = 2
                // Hanya bisa melihat usulan dari unitnya sendiri
                $query->where('unit_kerja.id', $pegawai['unit_kerja_id']);
            } else {
                // Koordinator unit lain hanya melihat usulan dari unitnya
                $query->where('unit_kerja.id', $pegawai['unit_kerja_id']);
            }
        } else {
            // Role lain hanya melihat usulan miliknya
            $query->where('usulan.upload_by', $sessionPegawaiId)
                  ->where('unit_kerja.id', $unit_id);
        }

        return $query->findAll();
    }
}
