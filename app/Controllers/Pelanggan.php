<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use CodeIgniter\Controller;

class Pelanggan extends BaseController
{
    protected $pelangganModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pelanggan',
            'pelanggan' => $this->pelangganModel->getAllPelanggan()
        ];


        return view('pelanggan/index', $data);
    }
}
