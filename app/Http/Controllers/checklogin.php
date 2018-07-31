<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        ->select(DB::raw('id,name,password'))
        ->whereRaw("username = '$username'")
        ->get();
        if(count($userresult) > 0){
            $result = json_decode($userresult, true);
            if (Hash::check($password, $result[0]['password'])) {
              $id = $result[0]['id'];
              $name = $result[0]['name'];
              Session::put('id',$id);
              Session::put('name',$name);
              Session::put('username',$username);
              return redirect('/')->with('login',$id);
            }
            return redirect('/')->with('login','login fail');
        }else{
            return redirect('/')->with('login','login fail');
        }
    }
    public function pslogininaddchild(Request $request){
        $username = $request->input('uname');
        $password = $request->input('pass');
        $userresult = DB::table('managers')
        ->select(DB::raw('*'))
        ->whereRaw("username = '$username'")
        ->get();
        if(count($userresult) > 0){
            $result = json_decode($userresult, true);
            if (Hash::check($password, $result[0]['password'])) {
              $id = $result[0]['id'];
              $name = $result[0]['name'];
              Session::put('id',$id);
              Session::put('name',$name);
              Session::put('username',$username);
              return redirect('/addchild')->with('login',$id);
            }
            return redirect('/addchild')->with('login','Username and Password not match');
        }else{
            return redirect('/addchild')->with('login','Username and Password not match');
        }
    }
}
