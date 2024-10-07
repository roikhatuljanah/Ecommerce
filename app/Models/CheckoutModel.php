<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'pesanan';
    protected $allowedFields = ['idkeranjang', 'kota', 'nama', 'alamat', 'email', 'hp', 'pesan', 'metode'];

    public function getPesananWithDetails($iduser)
    {
        $builder = $this->db->table('keranjang');
        $builder->select('keranjang.*, produk.nama as produk_nama, produk.harga as produk_harga');
        $builder->join('produk', 'produk.id = keranjang.kode_produk');
        $builder->where('keranjang.iduser', $iduser);

        return $builder->get()->getResultArray();
    }
}
