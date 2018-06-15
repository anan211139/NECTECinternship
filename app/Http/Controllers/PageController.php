<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function getlaravelpage(){
        return view('welcome');
    }
    public function gethome(){
        return view('home');
    }
    public function getlogin(){
        return view('login');
    }
    public function getregis(){
        return view('regis');
    }
    public function getcontent(){
        return view('content');
    }
}
