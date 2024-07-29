<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderBerandaModel extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image', 'title', 'description'];
    protected $useTimestamps = true;
}
