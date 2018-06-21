<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

class checklogin extends Controller
{
    public function pslogin(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        $userresult = DB::table(Managers)
                                ->where(['UNPR','=','$username'],
                                        ['PWPR','=','$password'])
                                ->get();
        if(isset($userresult)){
            return redirect('/')->with('login','login pass');
        }else{
            return redirect('/')->with('login','login fail');
        }
        return $username;
    }
}
