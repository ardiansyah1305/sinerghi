<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class OrganisasiModel extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nip',
        'gelar_depan',
        'nama',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'pangkat',
        'golongan_ruang',
        'jabatan_id',
        'unit_kerja_id',
        'kelas_jabatan',
        'jenis_kelamin',
        'status_pegawai',
        'status_pernikahan',
        'jumlah_anak',
        'foto',
        'agama' 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllPegawai()
    {
        return $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, jenjang_pangkat.nama_pangkat')
            ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left') 
            ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
            ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left') // Menghubungkan kode pangkat
            ->findAll();
    }    


public function pangkat()
{
    $pegawai = $this->findAll();

    foreach ($pegawai as &$emp) {
        $pangkat = $this->db->table('jenjang_pangkat')
            ->select('nama_pangkat')
            ->where('kode', $emp['pangkat'])
            ->get()
            ->getRowArray();

        $emp['nama_pangkat'] = $pangkat['nama_pangkat'] ?? 'Tidak Ada Pangkat';
    }

    return $pegawai;
}


public function geteselon1()
{
    return $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, jenjang_pangkat.nama_pangkat')
        ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left') 
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left') // Menghubungkan kode pangkat
        ->whereIn('jabatan.eselon', ['Ia', 'Ib']) // Filter untuk Eselon Ia dan Ib
        ->findAll();

}

public function geteselon2()
{
    return $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, jenjang_pangkat.nama_pangkat')
        ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left') 
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left') // Menghubungkan kode pangkat
        ->whereIn('jabatan.eselon', ['IIa', 'IIb']) // Filter untuk Eselon II
        ->findAll();
}

public function getPegawaiByNama($nama)
{
    return $this->select('pegawai.*, unit_kerja.nama_unit_kerja')
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->where('pegawai.nama', $nama)
        ->first();
}

public function getPegawaies2ByNama($nama)
{
    return $this->select('pegawai.*, unit_kerja.nama_unit_kerja AS unit_kerja_utama')
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->where('pegawai.nama', $nama)
        ->first();
}


public function getPegawaiUtamaByUnitKerja($unitKerjaId)
{
    // Ambil unit kerja berdasarkan id yang diberikan
    return $this->select('pegawai.*, unit_kerja.nama_unit_kerja') // Ambil nama unit kerja
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left') // Join dengan tabel unit kerja
        ->where('pegawai.unit_kerja_id', $unitKerjaId) // Filter berdasarkan unit kerja id
        ->where(function($query) use ($unitKerjaId) {
            // Menambahkan kondisi untuk memeriksa apakah unit kerja memiliki parent_id
            $query->where('unit_kerja.parent_id', $unitKerjaId)
                  ->orWhere('unit_kerja.id', $unitKerjaId); // Termasuk unit kerja utama
        })
        ->first();
}

public function getEselon2ByUnit($unitKerjaId)
{
    // Cari unit kerja eselon 1 (parent)
    $unitKerjaEselon1 = $this->db->table('unit_kerja')
        ->select('id, nama_unit_kerja')
        ->where('id', $unitKerjaId) // Cari unit kerja yang diberikan
        ->get()
        ->getRow();

    if (!$unitKerjaEselon1) {
        return []; // Jika unit kerja tidak ditemukan, kembalikan array kosong
    }

    // Cari unit kerja eselon 2 berdasarkan parent_id dari unit kerja eselon 1
    $unitKerjaEselon2 = $this->db->table('unit_kerja')
        ->select('id')
        ->where('parent_id', $unitKerjaEselon1->id) // Cari unit kerja anak
        ->get()
        ->getResultArray();

    // Ambil ID dari semua unit kerja anak
    $unitKerjaIds = array_column($unitKerjaEselon2, 'id');
    $unitKerjaIds[] = $unitKerjaId; // Tambahkan unit kerja utama ke dalam daftar ID

    // Ambil pegawai Eselon 2 dari unit kerja yang diberikan dan unit kerja anaknya
    return $this->select('pegawai.*, unit_kerja.nama_unit_kerja, jabatan.nama_jabatan')
        ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->whereIn('unit_kerja.id', $unitKerjaIds) // Ambil pegawai yang ada di unit kerja utama dan anaknya
        ->like('jabatan.eselon', 'II', 'after') // Pastikan hanya eselon II yang diambil
        ->findAll();
}

public function getBawahanByUnit($unitKerjaId)
{
    // Cari unit kerja bawahan berdasarkan parent_id
    $unitKerjaBawahan = $this->db->table('unit_kerja')
        ->select('id')
        ->where('parent_id', $unitKerjaId) // Unit kerja bawahan
        ->get()
        ->getResultArray();

    $unitKerjaIds = array_column($unitKerjaBawahan, 'id');
    $unitKerjaIds[] = $unitKerjaId;

    // Jika tidak ada unit kerja ID, kembalikan array kosong
    if (empty($unitKerjaIds)) {
        return [];
    }

    // Ambil data pegawai dengan jabatan dan golongan
    $results = $this->select('pegawai.*, jabatan.nama_jabatan, jabatan.is_fungsional, jabatan.is_pelaksana, jabatan.is_pppk, jabatan.is_non_asn, jenjang_pangkat.nama_pangkat, jenjang_pangkat.golongan, jenjang_pangkat.ruang, unit_kerja.nama_unit_kerja')
        ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
        ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.id', 'left')
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->whereIn('unit_kerja.id', $unitKerjaIds)
        ->groupStart()
            ->like('jabatan.eselon', 'III', 'after')
            ->orLike('jabatan.eselon', 'IV', 'after')
            ->orLike('jabatan.eselon', 'V', 'after')
        ->groupEnd()
        ->findAll();

    // Menambahkan tipe_pegawai berdasarkan kondisi jabatan
    foreach ($results as $key => $pegawai) {
        // Cek nilai kolom is_fungsional, is_pelaksana, is_pppk, dan is_non_asn di tabel jabatan
        if ($pegawai['is_fungsional']) {
            $results[$key]['tipe_pegawai'] = 'Fungsional';
        } elseif ($pegawai['is_pelaksana']) {
            $results[$key]['tipe_pegawai'] = 'Pelaksana';
        } elseif ($pegawai['is_pppk']) {
            $results[$key]['tipe_pegawai'] = 'PPPK';
        } elseif ($pegawai['is_non_asn']) {
            $results[$key]['tipe_pegawai'] = 'Non-ASN';
        } else {
            $results[$key]['tipe_pegawai'] = 'Tidak Diketahui';
        }
    }

    return $results;
}

public function getpegawaieselon2($unitKerjaId, $unitKerjaaId)
{
    // Cari unit kerja eselon 1
    $unitKerjaEselon1 = $this->db->table('unit_kerja')
        ->select('id, nama_unit_kerja')
        ->where('id', $unitKerjaId)
        ->get()
        ->getRow();

    if (!$unitKerjaEselon1) {
        return []; // Jika unit kerja eselon 1 tidak ditemukan, kembalikan array kosong
    }

    // Query untuk mendapatkan pegawai eselon 2
    $pegawaiEselon2 = $this->db->table('pegawai')
        ->select('pegawai.*, jabatan.nama_jabatan, jabatan.is_fungsional, jabatan.is_pelaksana, jabatan.is_pppk, jabatan.is_non_asn, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, unit_kerjaa.nama_unit_kerja')
        ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->where('pegawai.unit_kerja_id', $unitKerjaId) // Filter berdasarkan unit kerja
        ->like('jabatan.eselon', 'II', 'after') // Filter Eselon II
        ->get()
        ->getResultArray();

    // Menambahkan tipe pegawai berdasarkan jabatan
    foreach ($pegawaiEselon2 as $key => $pegawai) {
        if ($pegawai['is_fungsional']) {
            $pegawaiEselon2[$key]['tipe_pegawai'] = 'Fungsional';
        } elseif ($pegawai['is_pelaksana']) {
            $pegawaiEselon2[$key]['tipe_pegawai'] = 'Pelaksana';
        } elseif ($pegawai['is_pppk']) {
            $pegawaiEselon2[$key]['tipe_pegawai'] = 'PPPK';
        } elseif ($pegawai['is_non_asn']) {
            $pegawaiEselon2[$key]['tipe_pegawai'] = 'Non-ASN';
        } else {
            $pegawaiEselon2[$key]['tipe_pegawai'] = 'Tidak Diketahui';
        }
    }

    return $pegawaiEselon2;
}


// public function geteselon2ByUnit($unitKerjaId)
// {
//     return $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, unit_kerjaa.nama_unit_kerja')
//         ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left') 
//         ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left') 
//         ->join('unit_kerjaa', 'pegawai.unit_kerjaa_id = unit_kerjaa.id', 'left')
//         ->where('unit_kerjaa.id', $unitKerjaId) // Pastikan parameter benar
//         ->findAll();
// }


}