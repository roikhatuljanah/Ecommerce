<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{

    protected $table            = 'user';
    protected $allowedFields    = ['email', 'nama','password','Hakakses'];


    public function getAllPelanggan()
    {
        return $this->db->table('user')->get()->getResultArray();
    }
    public function getPelangganByIduser($iduser = false)
    {
        if ($iduser == false) {
            return $this->findAll();
        }

        return $this->where(['iduser' => $iduser])->first();
    }
}
