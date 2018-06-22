<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class Pagecontroller extends Controller
{
    public function getLaravelpage(){
        return view('welcome');
    }
    public function gethome(){
        $sessiondata = Session::get('username','default');
        if(session()->has('username')){
            return view('userpage');
        }else{
            return view('home');
        }
        
    }
}
