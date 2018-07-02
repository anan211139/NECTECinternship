<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Manager;
use App\Student;
use App\Studentparent;
use Session;

class checklogin extends Controller
{
    public function pslogin(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        $userresult = DB::table('managers')
        ->select(DB::raw('id'))
        ->whereRaw("username = '$username' and password = '$password'")
        ->get();
        if(count($userresult) > 0){
            $result = json_decode($userresult, true);
            $id = $result[0]['id'];
            Session::put('id',$id);
            Session::put('username',$username);
            return redirect('/')->with('login',$id);
        }else{
            return redirect('/')->with('login','login fail');
        }
    }
    public function pslogininaddchild(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        $userresult = DB::table('managers')
        ->select(DB::raw('*'))
        ->whereRaw("username = '$username' and password = '$password'")
        ->get();
        if(count($userresult) > 0){
            $result = json_decode($userresult, true);
            $id = $result[0]['id'];
            Session::put('id',$id);
            Session::put('username',$username);
            return redirect('/addchild')->with('login',$id);
        }else{
            return redirect('/addchild')->with('login','Username and Password not match');
        }
    }
}
