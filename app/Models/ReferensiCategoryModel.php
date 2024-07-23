<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferensiCategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul'];
    public $timestamps = false;
}
