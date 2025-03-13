<?php

namespace App\Models;

use CodeIgniter\Model;

class CalenderModel extends Model
{
    protected $table = 'calenders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'start', 'end'];

public function getLatestAnnouncements($limit = 15)
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }
}    
