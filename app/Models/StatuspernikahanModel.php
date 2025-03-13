<?php

namespace App\Models;

use CodeIgniter\Model;

class StatuspernikahanModel extends Model
{
    protected $table = 'status_pernikahan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status', 'kode'];
    // protected $useTimestamps = true;

}