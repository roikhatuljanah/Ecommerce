<?php

namespace App\Controllers;

use App\Models\KontakModel;
use CodeIgniter\Controller;

class Kontak extends BaseController
{
    protected $kontakModel;

    public function __construct()
    {
        $this->kontakModel = new KontakModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kontak',
            'kontak' => $this->kontakModel->getAllKontak()
        ];


        return view('kontak/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Kontak',
            'validation' => \Config\Services::validation()
        ];

        return view('kontak/tambah', $data);
    }

    public function simpan()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'nama1' => 'required',
            'email' => 'required|valid_email',
            'pesan' => 'required'
        ])) {
            return redirect()->to('/kontak/tambah')->withInput();
        }

        // Simpan data ke database
        $this->kontakModel->save([
            'nama' => $this->request->getVar('nama'),
            'nama1' => $this->request->getVar('nama1'),
            'email' => $this->request->getVar('email'),
            'pesan' => $this->request->getVar('pesan'),
        ]);

        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        // Redirect ke halaman index
        if(session()->get('hakakses') == 'admin' ){
            return redirect()->to('/kontak');
        }else{
            return redirect()->to('User/Home');
        }
        //return redirect()->to('/kontak');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit Data Kontak',
            'validation' => \Config\Services::validation(),
            'kontak' => $this->kontakModel->getKontakById($id),
        ];

        if (empty($data['kontak'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data ' . $id . ' tidak ditemukan');
        }

        return view('kontak/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'nama1' => 'required',
            'email' => 'required|valid_email',
            'pesan' => 'required'
        ])) {
            return redirect()->to('/kontak/edit/' . $id)->withInput();
        }

        // Simpan data ke database
        $this->kontakModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'nama1' => $this->request->getVar('nama1'),
            'email' => $this->request->getVar('email'),
            'pesan' => $this->request->getVar('pesan'),
        ]);

        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        // Redirect ke halaman index
        return redirect()->to('/kontak');
    }

    public function delete($id)
    {
        $this->kontakModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/kontak');
    }
}
