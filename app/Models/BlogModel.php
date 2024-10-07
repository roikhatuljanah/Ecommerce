<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{

    protected $table            = 'blog';
    protected $allowedFields    = ['nama', 'pembuat', 'tanggal', 'gambar'];


    public function getAllBlog()
    {
        return $this->db->table('blog')->get()->getResultArray();
    }
    public function getBlogById($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
