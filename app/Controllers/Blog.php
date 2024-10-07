<?php

namespace App\Controllers;

use \App\Models\BlogModel;

class Blog extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel =  new BlogModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Blog',
            'blog' => $this->blogModel->getAllBlog(),
            'validation' => \Config\Services::validation(), // Include the validation object
        ];


        return view('blog/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Blog',
            'validation' => \Config\Services::validation()
        ];

        return view('blog/tambah', $data);
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
            'pembuat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tanggal' => [
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
            return redirect()->to('blog/tambah')->withInput();
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
            $fileSampul->move('images/blog', $namaSampul);
        }
        // validasi data sukses
        $this->blogModel->save([
            'nama' => $this->request->getVar('nama'),
            'pembuat' => $this->request->getVar('pembuat'),
            'tanggal' => $this->request->getVar('tanggal'),
            'gambar' => $namaSampul
        ]);
        // menampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!.');
        // kembali ke halaman index Pegawai
        return redirect()->to('/blog');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit Data Blog',
            'validation' => \Config\Services::validation(),
            'blog' => $this->blogModel->getBlogById($id),
        ];
        // jika id data tidak ada di table
        if (empty($data['blog'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data ' . $id . ' tidak ditemukan');
        };

        return view('blog/edit', $data);
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
            'pembuat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tanggal' => [
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
            return redirect()->to('blog/edit/' . $this->request->getVar('id'))->withInput();
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
            $fileSampul->move('images/blog', $namaSampul);

            // hapus file lama
            if ($this->request->getVar('gambarLama') != 'default.jpg') {
                unlink('images/blog' . $this->request->getVar('gambarLama'));
            }
        }
        // validasi data sukses
        $this->blogModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'pembuat' => $this->request->getVar('pembuat'),
            'tanggal' => $this->request->getVar('tanggal'),
            'gambar' => $namaSampul
        ]);
        // menampilkan pesan sukses
        session()->setFlashdata('pesan', 'Data berhasil diedit!.');
        // kembali ke halaman index Pegawai
        return redirect()->to('/blog');
    }

    public function delete($id)
    {
        $blog = $this->blogModel->find($id);

        // cek jika gambar default
        if ($blog['gambar'] != 'default.jpg') {
            // hapus gambar
            unlink('images/blog/' . $blog['gambar']);
        }

        $this->blogModel->delete($id);
        // menampilkan pesan data sukses dihapus
        session()->setFlashdata('pesan', 'Data berhasil dihapus!..');
        // kembali ke halaman index mahasiswa
        return redirect()->to('blog');
    }
}
