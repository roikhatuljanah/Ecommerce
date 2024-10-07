<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{

    protected $table            = 'produk';
    protected $allowedFields    = ['nama', 'deskripsi','harga','stok','gambar'];


    public function getAllProduk()
    {
        return $this->db->table('produk')->get()->getResultArray();
    }
    public function getProdukById($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
