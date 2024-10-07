<?php

namespace App\Controllers;

use \App\Models\TestimoniModel;

class Testimoni extends BaseController
{
    protected $testimoniModel;

    public function __construct()
    {
        $this->testimoniModel =  new TestimoniModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Testimoni',
            'testimoni' => $this->testimoniModel->getAllTestimoni()
        ];

        if(session()->get('iduser') == '' && session()->get('iduser') == null){
            return redirect()->to('/Login');    
        }

        return view('testimoni/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Testimoni',
            'validation' => \Config\Services::validation()
        ];

        return view('testimoni/tambah', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'pekerjaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Pilih File / Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            // jika data tidak valid kembalikan ke halaman tambah
            return redirect()->to('testimoni/tambah')->withInput();
        }
        // ambil gambar
        $fileSampul = $this->request->getFile('gambar');

        // apakah tidak ada gambar yang di upload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();

            // pindahkan file ke folder img
            $fileSampul->move('images/testimoni', $namaSampul);
        }
        // validasi data sukses
        $this->testimoniModel->save([
            'nama' => $this->request->getVar('nama'),
            'pekerjaan' => $this->request->getVar('pekerjaan'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaSampul
        ]);
        // menampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!.');
        // kembali ke halaman index Pegawai
        return redirect()->to('/testimoni');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit Data Testimoni',
            'validation' => \Config\Services::validation(),
            'testimoni' => $this->testimoniModel->getTestimoniById($id),
        ];
        // jika id data tidak ada di table
        if (empty($data['testimoni'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data ' . $id . ' tidak ditemukan');
        };

        return view('testimoni/edit', $data);
    }

    public function update($id)
    {

        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'pekerjaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            // jika data tidak valid kembalikan ke halaman tambah pegawai
            return redirect()->to('testimoni/edit/' . $this->request->getVar('id'))->withInput();
        }
        // ambil gambar
        $fileSampul = $this->request->getFile('gambar');

        // apakah tidak ada gambar yang di upload
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('gambarLama');
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();

            // pindahkan file ke folder img
            $fileSampul->move('images/testimoni', $namaSampul);

            // hapus file lama
            if ($this->request->getVar('gambarLama') != 'default.jpg') {
                unlink('images/testimoni' . $this->request->getVar('gambarLama'));
            }
        }
        // validasi data sukses
        $this->testimoniModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'pekerjaan' => $this->request->getVar('pekerjaan'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaSampul
        ]);
        // menampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil diedit!.');
        // kembali ke halaman index Pegawai
        return redirect()->to('/testimoni');
    }

    public function delete($id)
    {
        $testimoni = $this->testimoniModel->find($id);

        // cek jika gambar default
        if ($testimoni['gambar'] != 'default.jpg') {
            // hapus gambar
            unlink('images/testimoni/' . $testimoni['gambar']);
        }

        $this->testimoniModel->delete($id);
        // menampilkan pesan data sukses dihapus
        session()->setFlashdata('pesan', 'Data berhasil dihapus!..');
        // kembali ke halaman index mahasiswa
        return redirect()->to('testimoni');
    }
}
