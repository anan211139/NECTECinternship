<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Student;
use Session;

class Pagecontroller extends Controller
{
    public function getLaravelpage(){
        return view('welcome');
    }
    public function addchildpage(){
        return view('addchild');
    }

    public function gethome(){
        $sessiondata = Session::get('username','default');
        if(session()->has('username')){
            return view('userpage');
        }else{
            return view('home');
        }
        
    }
    public function addchild($id){
        Session::put('line_code',$id);
        $getpic = new Student;
        $getpicresult = DB::table('students')
        ->select(DB::raw('local_pic'))
        ->where('line_code' , $id)
        ->get();
        $resultArray = json_decode($getpicresult, true);
        $result = $resultArray[0]["local_pic"];
        Session::put('local_pic',$result);
        return redirect('/addchild')->with('code',$id);
        https://www.picz.in.th/images/2018/05/10/z0CEml.jpg
    }
    
}
