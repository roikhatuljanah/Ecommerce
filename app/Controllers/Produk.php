<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Controller;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Produk',
            'produk' => $this->produkModel->getAllProduk()
        ];

        if(session()->get('iduser') == '' && session()->get('iduser') == null){
            return redirect()->to('/Login');    
         }

        return view('produk/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Produk',
            'validation' => \Config\Services::validation()
        ];

        return view('produk/tambah', $data);
    }

    public function simpan()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => [
                'uploaded[gambar]',
                'mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'max_size[gambar,1024]',
            ],
        ])) {
            return redirect()->to('/produk/tambah')->withInput();
        }

        // Handle image upload
        $gambar = $this->request->getFile('gambar');
        $gambarName = $gambar->getRandomName();
        $gambar->move('images/produk', $gambarName);

        // Simpan data ke database
        $this->produkModel->save([
            'nama' => $this->request->getVar('nama'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $gambarName,
        ]);

        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        // Redirect ke halaman index
        return redirect()->to('/produk');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit Data Produk',
            'validation' => \Config\Services::validation(),
            'produk' => $this->produkModel->getProdukById($id),
        ];

        if (empty($data['produk'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data ' . $id . ' tidak ditemukan');
        }

        return view('produk/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => [
                'mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'max_size[gambar,1024]',
            ],
        ])) {
            return redirect()->to('/produk/edit/' . $id)->withInput();
        }

        // Handle image upload
        $gambar = $this->request->getFile('gambar');
        $gambarName = $gambar->getRandomName();
        $gambar->move('images/produk', $gambarName);

        // Get the existing data
        $existingData = $this->produkModel->find($id);

        // Delete the old image if it's not the default one
        if ($existingData['gambar'] != 'default.jpg') {
            unlink('images/produk/' . $existingData['gambar']);
        }

        // Update the data in the database
        $this->produkModel->update($id, [
            'nama' => $this->request->getVar('nama'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $gambarName,
        ]);

        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        // Redirect ke halaman index
        return redirect()->to('/produk');
    }

    public function delete($id)
    {
        // Get the existing data
        $existingData = $this->produkModel->find($id);
    
        // Delete the image if it's not the default one
        if ($existingData['gambar'] != 'default.jpg') {
            unlink('images/produk/' . $existingData['gambar']);
        }
    
        // Delete the data from the database
        $this->produkModel->delete($id);
    
        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
    
        // Redirect ke halaman index
        return redirect()->to('/produk');
    }
    
}
