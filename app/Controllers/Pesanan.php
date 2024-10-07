<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class Pesanan extends BaseController
{
    protected $checkoutModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data pesanan',
            'pesanan' => $this->checkoutModel->getPesananWithDetails(),
        ];

        return view('pesanan/index', $data);
    }

    public function delete($idpesanan)
    {
        $this->checkoutModel->delete($idpesanan);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/checkout');
    }
}
