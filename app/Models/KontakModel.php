<?php

namespace App\Models;

use CodeIgniter\Model;

class KontakModel extends Model
{

    protected $table            = 'kontak';
    protected $allowedFields    = ['nama', 'nama1', 'email', 'pesan'];


    public function getAllKontak()
    {
        return $this->db->table('kontak')->get()->getResultArray();
    }
    public function getKontakById($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
