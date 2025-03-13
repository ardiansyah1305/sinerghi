<?php

namespace App\Models;

use CodeIgniter\Model;

class TiketModel extends Model
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
        'lampiran',
        'deskripsi'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function detail_tiket_pegawai($kodeTiket)
    {
        return $this->select('tiket.*, pegawai.nama as nama_pegawai, pegawai.gelar_depan as gelar_depan, pegawai.gelar_belakang as gelar_belakang, unit_kerja.nama_unit_kerja as unit_kerja, layanan_servicedesk.jenis_layanan as jenis_layanan')
            ->join('pegawai', 'pegawai.id = tiket.id_pegawai')
            ->join('unit_kerja', 'tiket.id_unit_kerja = unit_kerja.id')
            ->join('layanan_servicedesk', 'tiket.id_layanan = layanan_servicedesk.id')
            ->where('tiket.kode_tiket', $kodeTiket)
            ->first();
    }

    public function tiket_pegawai_unit_all($unit_kerja,$limit, $offset)
    {
        return $this->select('tiket.*, layanan_servicedesk.jenis_layanan as jenis_layanan')
            ->join('unit_kerja', 'tiket.id_unit_kerja = unit_kerja.id')
            ->join('layanan_servicedesk', 'tiket.id_layanan = layanan_servicedesk.id')
            ->where('tiket.id_unit_kerja', $unit_kerja)
            ->limit($limit, $offset)
            ->findAll();
    }

    public function updateStatus($tiket_id, $status)
    {
        return $this->update($tiket_id, ['status' => $status]);
    }

    public function countTiketByUnit($unit_kerja)
    {
        return $this->where('id_unit_kerja', $unit_kerja)->countAllResults();
    }
    public function countTiketNew($unit_kerja)
    {
        return $this->where('id_unit_kerja', $unit_kerja)
                ->where('status', '0')
                ->countAllResults();
    }

    public function countTiketProccess($unit_kerja)
    {
        return $this->where('id_unit_kerja', $unit_kerja)
                ->where('status', '1')
                ->countAllResults();
    }

    public function countTiketDone($unit_kerja)
    {
        return $this->where('id_unit_kerja', $unit_kerja)
                ->where('status', '2')
                ->countAllResults();
    }

    public function countTiketCancel($unit_kerja)
    {
        return $this->where('id_unit_kerja', $unit_kerja)
                ->where('status', '3')
                ->countAllResults();
    }

    // public function detail_tiket_pegawai_penerima_tugas($kodeTiket)
    // {
    //     return $this->select('tiket.*, pegawai.nama, pegawai.gelar_depan, pegawai.gelar_belakang, unit_kerja.nama_unit_kerja as unit_kerja')
    //         ->join('pegawai', 'pegawai.id = tiket.id_pegawai')
    //         ->join('unit_kerja', 'tiket.id_id_unit_kerja = unit_kerja.id')
    //         ->where('tiket.kode_tiket', $kodeTiket)
    //         ->first();
    // }
}
