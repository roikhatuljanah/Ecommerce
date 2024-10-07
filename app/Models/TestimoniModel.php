<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimoniModel extends Model
{

    protected $table            = 'testimoni';
    protected $allowedFields    = ['nama', 'pekerjaan', 'deskripsi', 'gambar'];


    public function getAllTestimoni()
    {
        return $this->db->table('testimoni')->get()->getResultArray();
    }
    public function getTestimoniById($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
