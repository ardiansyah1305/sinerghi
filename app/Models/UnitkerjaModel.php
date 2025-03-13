<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitkerjaModel extends Model
{
    protected $table = 'unit_kerja';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_unit_kerja', 'parent_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $softDelete = true;
    protected $dateFormat = 'datetime';

    public function getMenteri()
{
    // Fetch the Menteri row where parent_id is NULL
    return $this->where('parent_id', null)->first();
}

public function getParentName($parentId)
{
    return $this->where('id', $parentId)->first(); // Ambil nama_unit_kerja berdasarkan ID parent
}


public function getDataDropdown()
    {
        return $this->findAll(); // Mengambil semua data
    }


public function getAllUnitKerja()
{
    return $this->select('id, nama_unit_kerja')->orderBy('nama_unit_kerja', 'ASC')->findAll();
}

public function getAllUnitKerjaWithParent()
{
    $allData = $this->findAll(); // Ambil semua data tanpa pagination

    // Tambahkan parent_name ke setiap data
    foreach ($allData as &$unit) {
        if (!empty($unit['parent_id'])) {
            $parent = $this->getParentName($unit['parent_id']);
            $unit['parent_name'] = $parent ? $parent['nama_unit_kerja'] : 'Unknown Parent';
        } else {
            $unit['parent_name'] = 'Tidak Ada Induk';
        }
    }

    return $allData;
}

/**
 * Get all child units (direct and indirect) for a given unit
 * 
 * @param int $unitId The parent unit ID
 * @return array Array of unit IDs that are children of the given unit
 */
public function getAllChildUnits($unitId)
{
    // Start with direct children
    $directChildren = $this->where('parent_id', $unitId)->findAll();
    
    $allChildrenIds = [];
    foreach ($directChildren as $child) {
        $allChildrenIds[] = $child['id'];
        
        // Recursively get children of this child
        $grandChildren = $this->getAllChildUnits($child['id']);
        $allChildrenIds = array_merge($allChildrenIds, $grandChildren);
    }
    
    return $allChildrenIds;
}

}
