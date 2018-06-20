<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class regisController extends Controller
{
    public function psregis(Request $request){
        $username = $request->input('uname');
        $password = $request->input('psw');
        $repassword = $request->input('repsw');
        $email = $request->input('email');
        if($password != $repassword){
            return $email;
        }else{
            return $password;
        } 
    }
}
