<?php

namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Controller;
use PDO;

class Login extends BaseController
{
    protected $loginModel;

    public function __construct()
    {
        $this->LoginModel = new LoginModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('v_login', $data);
    }

    public function proses_login()
    {
        $lm = $this->LoginModel;

        $username = $this->request->getPost('email');
        $password = md5($this->request->getPost('password'));

        $cek_data = $lm->getWhere('user', '*', ['email' => $username, 'password' => $password])->getRow();
        if ($cek_data) {
            $sess = [
                'iduser' => $cek_data->iduser,
                'email' => $cek_data->email,
                'nama' => $cek_data->nama,
                'hakakses'=> $cek_data->hakakses
            ];
            session()->set($sess);
            if($cek_data->hakakses == 'admin'){
                return redirect()->to('/Admin');
            }else{
                return redirect()->to('User/Home');
            }
            
        } else {
          $sess =  [
                'pesan' => 'Username Atau Password Salah',
                'oke' => 'Gagal'
            ];
            session()->set($sess);
            return redirect()->to('/Login');
        }
    }


    public function logout()
    {
        $array_items = ['iduser','email','nama','hakases'];
        session()->remove($array_items);
        return redirect()->to('Login');
    }

    public function register()
    {
        return view('v_register');
    }


    public function simpan_register()
    {
        $kirim = [
            'email' => $this->request->getPost('email'),
            'nama' =>  $this->request->getPost('nama'),
            'hakakses'=> 'user',
            'password'  =>  md5($this->request->getPost('password'))
        ];        

        $simpan = $this->LoginModel->insData('user', $kirim);
        if($simpan){
            return redirect()->to('/Login');
        }else{
            return redirect()->to('/Login/register');
        }
    }
}
