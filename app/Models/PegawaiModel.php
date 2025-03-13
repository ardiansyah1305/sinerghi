<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
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
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at'; // Kolom soft delete
    protected $useSoftDeletes = true;       // Aktifkan soft delete


    // Method untuk join dengan tabel jabatan dan unit kerja
    public function getAllPegawai()
    {
        return $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, status_pegawai.nama_status AS nama_status, jenjang_pangkat.nama_pangkat AS pangkat_pegawai, agama.nama_agama AS agama_nama')
            ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
            ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
            ->join('status_pegawai', 'pegawai.status_pegawai = status_pegawai.kode', 'left')
            ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left')
            ->join('agama', 'pegawai.agama = agama.kode', 'left')
            ->findAll();
    }

    public function getPegawaiByParentUnit($parent_unit_id)
    {
        return $this->select('pegawai.*, unit_kerja.nama_unit_kerja')
            ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
            ->where('unit_kerja.id', $parent_unit_id)
            ->orWhere('unit_kerja.parent_id', $parent_unit_id)
            ->orderBy('unit_kerja.nama_unit_kerja', 'ASC')
            ->orderBy('pegawai.nama', 'ASC')
            ->findAll();
    }

    public function searchNIP($search)
    {
        return $this->select('nip, nama')
            ->like('nip', $search)
            ->orLike('nama', $search)
            ->findAll(10);
    }

    // public function getAllPegawai()
// {
//     $result = $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, jenjang_pangkat.nama_pangkat')
//         ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')  
//         ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
//         ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left')
//         ->findAll();

    //     // Debugging untuk memeriksa data
//     echo '<pre>';
//     print_r($result);
//     echo '</pre>';
//     die();

    //     return $result;
// }

    public function getNipWithNama()
    {
        return $this->select('pegawai.nip, pegawai.nama as nama_pegawai')->findAll();
    }


    public function Pegawaidetail($nip)
    {
        return $this->select('pegawai.*, unit_kerja.nama_unit_kerja as unit_kerja, unit_kerja.id as id_unit')
            ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
            // Perbaiki kolom join
            ->where('pegawai.nip', $nip)
            ->first();
    }

    public function Pegawaitiket($kode_unit)
    {
        return $this->select('pegawai.*, unit_kerja.id as id_unit')
            ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
            ->join('tiket', 'tiket.id_unit_kerja = unit_kerja.id')
            // Perbaiki kolom join
            ->where('pegawai.unit_kerja_id', $kode_unit)
            ->first();
    }

    public function getPegawaiByUnitAndRole($unit_id, $role_id)
    {
        $query = $this->select('pegawai.*, unit_kerja.nama_unit_kerja, unit_kerja.parent_id')
                     ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id');

        if ($role_id == 1 && $unit_id != 2) {
            // For role 1 and unit not 2, get pegawai with same parent_id
            $subquery = $this->db->table('unit_kerja')
                                ->select('parent_id')
                                ->where('id', $unit_id)
                                ->get()
                                ->getRow();
            
            if ($subquery && $subquery->parent_id) {
                $query->where('unit_kerja.parent_id', $subquery->parent_id);
            }
        } else {
            // For unit_id = 2 or other roles, get pegawai from same unit
            $query->where('unit_kerja.id', $unit_id);
        }

        return $query->orderBy('pegawai.nama', 'ASC')->findAll();
    }

    /**
     * Get detailed information for a single employee
     * 
     * @param int $id Employee ID
     * @return array|null Employee data with all related information
     */
    public function getDetailedPegawai($id)
    {
        return $this->select('
            pegawai.*,
            jabatan.nama_jabatan,
            unit_kerja.nama_unit_kerja,
            parent_unit.nama_unit_kerja AS parent_unit_name,
            status_pegawai.nama_status AS status_pegawai_nama,
            IFNULL(status_pernikahan.status, "-") AS status_pernikahan_nama,
            IFNULL(jenjang_pangkat.nama_pangkat, "-") AS nama_pangkat,
            IFNULL(agama.nama_agama, "-") AS nama_agama
        ')
        ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
        ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
        ->join('unit_kerja AS parent_unit', 'unit_kerja.parent_id = parent_unit.id', 'left')
        ->join('status_pegawai', 'pegawai.status_pegawai = status_pegawai.kode', 'left')
        ->join('status_pernikahan', 'pegawai.status_pernikahan = status_pernikahan.kode', 'left')
        ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left')
        ->join('agama', 'pegawai.agama = agama.kode', 'left')
        ->where('pegawai.id', $id)
        ->first();
    }

    /**
     * Search for employees by name
     * 
     * @param string $search Search term
     * @return array Array of employee data
     */
    public function searchPegawai($search)
    {
        return $this->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama, status_pegawai.nama_status AS nama_status, jenjang_pangkat.nama_pangkat AS pangkat_pegawai, agama.nama_agama AS agama_nama')
            ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
            ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id', 'left')
            ->join('status_pegawai', 'pegawai.status_pegawai = status_pegawai.kode', 'left')
            ->join('jenjang_pangkat', 'pegawai.pangkat = jenjang_pangkat.kode', 'left')
            ->join('agama', 'pegawai.agama = agama.kode', 'left')
            ->like('pegawai.nama', $search)
            ->orLike('pegawai.nip', $search)
            ->findAll();
    }
}
