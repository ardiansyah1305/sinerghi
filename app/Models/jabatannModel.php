<?php

namespace App\Models;

use CodeIgniter\Model;

 
class jabatannModel extends Model
{

    public function selectQuery()
    {
        $builder = $this->db->table("jabatan");
        $builder->select("*");
        // $builder->where("key", "1213");
        $result = $builder->get();
        // echo $this->db->getLastQuery();

        return $result->getResult();

        // "SELECT * FROM jabatan WHERE key = '1213'";
    }

    public function selectRow($id)
    {
        $builder = $this->db->table("jabatan");
        $builder->select("*");
        $builder->where("id", $id);
        $result = $builder->get();
        // echo $this->db->getLastQuery();

        return $result->getRow();

        // "SELECT * FROM jabatan WHERE key = '1213'";
    }
    public function insertValue($data)
    {
        $builder = $this->db->table("jabatan");
        return  $builder->insert($data);
    }
    public function updateValue($id, $data)
    {
        $builder = $this->db->table("jabatan");
        $query =  $builder->where("id", $id);
        return  $query->update($data);
    }
}
