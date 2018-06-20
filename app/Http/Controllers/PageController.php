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
        $password = $request->input('pass');
        return $username;
    }
    public function psregis(Request $request){
        $username = $request->input('uname');
        $password = $request->input('psw');
        $repassword = $request->input('repsw');
        $email = $request->input('email');
        if($password == $repassword){
            return $email;
        }else{
            return $username;
        }
        
    }
}
