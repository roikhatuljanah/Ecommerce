<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{

    protected $table            = 'client';
    protected $allowedFields    = ['nama', 'email'];


    public function getAllClient()
    {
        return $this->db->table('client')->get()->getResultArray();
    }
    public function getClientById($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
