<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;

class logoutcontroller extends Controller
{
    public function logout(){
        Session::forget('username');
        return view('home');
    }
}
