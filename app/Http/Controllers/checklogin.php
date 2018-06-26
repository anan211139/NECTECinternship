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
        $userresult = DB::table('managers')
        ->select(DB::raw('*'))
        ->whereRaw("username = '$username' and password = '$password'")
        ->get();
        $id = $userresult[0]['id'];
        if(count($userresult) > 0){
            Session::put('id',$id);
            Session::put('username',$username);
            $sessiondata = Session::get('username','default');
            return redirect('/')->with('login',$sessiondata);
        }else{
            return redirect('/')->with('login','login fail');
        }
    }
}
