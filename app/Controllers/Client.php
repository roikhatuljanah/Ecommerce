<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\Controller;

class Client extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Client',
            'client' => $this->clientModel->getAllClient()
        ];


        return view('client/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Client',
            'validation' => \Config\Services::validation()
        ];

        return view('client/tambah', $data);
    }

    public function simpan()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'email' => 'required|valid_email',
        ])) {
            return redirect()->to('/client/tambah')->withInput();
        }

        // Simpan data ke database
        $this->clientModel->save([
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
        ]);

        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        // Redirect ke halaman index

        if(session()->get('hakakses') == 'admin' ){
            return redirect()->to('/client');
        }else{
            return redirect()->to('User/Home');
        }
        
       
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit Data Client',
            'validation' => \Config\Services::validation(),
            'client' => $this->clientModel->getClientById($id),
        ];

        if (empty($data['client'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data ' . $id . ' tidak ditemukan');
        }

        return view('client/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'email' => 'required|valid_email',
        ])) {
            return redirect()->to('/client/edit/' . $id)->withInput();
        }

        // Simpan data ke database
        $this->clientModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
        ]);

        // Tampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        // Redirect ke halaman index
        return redirect()->to('/client');
    }

    public function delete($id)
    {
        $this->clientModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/client');
    }
}
