<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function getLaravelpage(){
        return view('welcome');
    }
    public function getLogin(){
        return view('login');
    }
    public function getRegis(){
        return view('regis');
    }
}
