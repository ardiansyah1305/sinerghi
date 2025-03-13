<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_jabatan', 'tipe_jabatan','eselon'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at'; // Kolom soft delete
    protected $useSoftDeletes = true;

    public function getAllJabatan()
    {
        return $this->select('jabatan.id as id_jabatan, jabatan.nama_jabatan as nama_jabatan, jabatan.tipe_jabatan as tipe_jabatan, eselon.nama_eselon')
        ->join('eselon',' jabatan.eselon = eselon.kode')
        ->orderBy('jabatan.id','ASC')
        ->findAll();
    }
}
