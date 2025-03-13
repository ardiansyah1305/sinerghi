<?php

namespace App\Models;

use CodeIgniter\Model;

class riwayat_pendidikanModel extends Model
{
    protected $table = 'riwayat_pendidikan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'pegawai_id', 'jenjang', 'jurusan', 'universitas', 'tahun_masuk', 'tahun_lulus'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Method untuk join dengan tabel jabatan dan unit kerja
    public function getAllriwayat_pendidikan()
{
    return $this->select('riwayat_pendidikan.*, pegawai.nama as nama_pegawai') // Tambahkan alias nama_pegawai
                ->join('pegawai', 'riwayat_pendidikan.pegawai_id = pegawai.id', 'left') // Gunakan 'left' join jika relasi opsional
                ->findAll();
}
}