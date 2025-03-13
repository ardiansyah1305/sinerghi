<?php

namespace App\Models;

use CodeIgniter\Model;

class CardBerandaModel extends Model
{
    protected $table      = 'cards';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['title', 'short_description', 'description', 'image', 'start', 'end'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

public function getLatestAnnouncements($limit = 15)
     {
         return $this->orderBy('created_at', 'DESC')->findAll($limit);
     }
 }