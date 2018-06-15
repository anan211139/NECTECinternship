<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function getLaravelpage(){
        return view('welcome');
    }
    public function getHome(){
        return view('home');
    }
    public function getLogin(){
        return view('login');
    }
    public function getRegis(){
        return view('regis');
    }
    public function getContent(){
        return view('content');
    }
}
