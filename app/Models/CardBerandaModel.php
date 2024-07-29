<?php

namespace App\Models;

use CodeIgniter\Model;

class CardBerandaModel extends Model
{
    protected $table = 'cards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'image', 'date'];
    protected $useTimestamps = true;
}
