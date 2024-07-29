<?php

namespace App\Models;

use CodeIgniter\Model;

class PopupBerandaModel extends Model
{
    protected $table = 'popups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image'];
    protected $useTimestamps = true;
}
