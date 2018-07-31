<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;

class logoutcontroller extends Controller
{
    public function logout(){
        Session::flush();
        return redirect('/');
    }
}
