<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Manager;

class checklogin extends Controller
{
    public function pslogin(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        $userresult = DB::table('Managers')
        ->select(DB::raw('*'))
        ->whereRaw("UNPR = '$username' and PWPR = '$password'")
        ->get();
        if(count($userresult) > 0){
            return redirect('/')->with('login','login pass');
        }else{
            return redirect('/')->with('login','login fail');
        }
    }
}
