<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table            = 'chat';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_tiket', 'kode_tiket', 'id_pegawai', 'lampiran', 'deskripsi'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function chattiketpegawai($kodeTiket)
    {
        return $this->select('chat.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id = chat.id_pegawai')
            ->where('chat.kode_tiket', $kodeTiket)
            ->findAll();
    }
}
