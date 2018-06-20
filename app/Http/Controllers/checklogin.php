<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class checklogin extends Controller
{
    public function pslogin(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        return $username;
    }
}
