<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Manager;
use Session;
class checklogin extends Controller
{
    public function pslogin(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        $userresult = DB::table('Managers')
        ->select(DB::raw('*'))
        ->whereRaw("username = '$username' and password = '$password'")
        ->get();

        if(count($userresult) > 0){
            Session::put('username',$username);
            $sessiondata = Session::get('username','default');
            return redirect('/')->with('login',$sessiondata);
        }else{
            return redirect('/')->with('login','login fail');
        }
    }
}
