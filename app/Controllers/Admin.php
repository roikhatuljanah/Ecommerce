<?php

namespace App\Controllers;

class Admin extends BaseController
{

    public function __construct()
    {
        if(session()->get('iduser') == '' && session()->get('iduser') == null){
            return redirect()->to('/Login');    
         }
    }


    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin'
        ];
        
        if(session()->get('iduser') == '' && session()->get('iduser') == null){
            return redirect()->to('/Login');    
         }
        return view('admin/index', $data);
    }
}
