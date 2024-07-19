<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentModel extends Model
{
    protected $table = 'contents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'deskripsi', 'unit_terkait', 'tanggal', 'file_upload', 'parent_id'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
