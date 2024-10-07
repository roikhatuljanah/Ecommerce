<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\ProdukModel;
use App\Models\TestimoniModel;
use App\Models\KontakModel;
use App\Models\BlogModel;
use App\Models\CheckoutModel;
use App\Models\LoginModel;

class Home extends BaseController
{
    protected $clientModel;
    protected $produkModel;
    protected $testimoniModel;
    protected $kontakModel;
    protected $checkoutModel;
    protected $blogModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->produkModel = new ProdukModel();
        $this->testimoniModel = new TestimoniModel();
        $this->kontakModel = new KontakModel();
        $this->blogModel = new BlogModel();
        $this->checkoutModel = new checkoutModel();
        $this->LoginModel = new LoginModel();
    }

    public function index()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\Home', $data);
    }

    public function simpan_keranjang($kode_produk)
    {
        $simpan = [
            'kode_produk' => $kode_produk,
            'qty'           => 1,
            'iduser'        => session()->get('iduser')

        ];
        $add = $this->LoginModel->insData('keranjang',$simpan);
        return redirect()->to('User/Home/shop');
    }


    public function shop()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'mod'       => $this->LoginModel,
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\shop',$data);
    }

    public function services()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\services',$data);
    }

    public function blog()
    {  $data = [
        'client' => $this->clientModel->getAllClient(),
        'produk' => $this->produkModel->getAllProduk(),
        'testimoni' => $this->testimoniModel->getAllTestimoni(),
        'kontak' => $this->kontakModel->getAllKontak(),
        'blog' => $this->blogModel->getAllBlog(),
        'validation' => \Config\Services::validation(), // Include the validation object
    ];

        return view('pages\users\blog',$data);
    }
    public function contact()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\contact',$data);
    }
    public function cart()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'mod'       => $this->LoginModel,
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\cart',$data);
    }
    public function checkout()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'mod'       => $this->LoginModel,
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\checkout',$data);
    }


public function simpan_checkout()
{
    $iduser = session()->get('iduser');
    $keranjangData = $this->checkoutModel->getPesananWithDetails($iduser);

    $subtotal = 0;
    $sb = 0;
    foreach ($keranjangData as $d) {
        $total_produk = $d['produk_harga'] * $d['qty'];
        $subtotal += $total_produk;
        $sb += $d['qty'];
    }

    // Insert data into pesanan table
    $data = [
        'idkeranjang' => $keranjangData[0]['id_keranjang'],
        'kota' => $this->request->getPost('kota'),
        'nama' => $this->request->getPost('nama'),
        'alamat' => $this->request->getPost('alamat'),
        'email' => $this->request->getPost('email'),
        'hp' => $this->request->getPost('hp'),
        'pesan' => '',
        'metode' => '',
    ];

    $this->checkoutModel->insert($data);

    // Clear keranjang data after checkout (optional)
    // $this->checkoutModel->delete(['iduser' => $iduser]);

    // Fetch pesanan data after insertion
    $pesananData = $this->checkoutModel->getPesanan();

    $data = [
        'client' => $this->clientModel->getAllClient(),
        'produk' => $this->produkModel->getAllProduk(),
        'testimoni' => $this->testimoniModel->getAllTestimoni(),
        'kontak' => $this->kontakModel->getAllKontak(),
        'blog' => $this->blogModel->getAllBlog(),
        'pesanan' => $pesananData, // Fetch pesanan data
        'mod' => $this->LoginModel,
        'validation' => \Config\Services::validation(),
    ];

    return view('pages\users\thankyou', $data);
}


    public function thankyou()
    {
        $data = [
            'client' => $this->clientModel->getAllClient(),
            'produk' => $this->produkModel->getAllProduk(),
            'testimoni' => $this->testimoniModel->getAllTestimoni(),
            'kontak' => $this->kontakModel->getAllKontak(),
            'blog' => $this->blogModel->getAllBlog(),
            'mod'       => $this->LoginModel,
            'validation' => \Config\Services::validation(), // Include the validation object
        ];

        return view('pages\users\thankyou',$data);
    }
}
