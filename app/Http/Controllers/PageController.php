<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function getLaravelpage(){
        return view('welcome');
    }
    public function gethome(){
        return view('home');
    }
    public function pslogin(Request $request){
        $username = $request->input('uname');
        return $username;
    }
}
