<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Student;
use App\Manager;
use App\Studentparent;
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
        if(session()->has('username')){
            $id = session('id', 'default');
            // query child
            $querystatement = new Student;
            $jsonresult = DB::table('students')
            ->rightjoin('studentparents','students.line_code','=','studentparents.line_code')
            ->leftjoin('managers','studentparents.parent_id','=','managers.id')
            ->select(DB::raw('students.line_code'))
            ->where('studentparents.parent_id',$id)
            ->get();
            // return $jsonresult;
            $arrayresult = json_decode($jsonresult, true);
            $countchild = count($jsonresult);
            // return $countchild;
            Session::put('countchild',$countchild);
            if($countchild==1){
                return view('userpage');
            }
            if($countchild>=2){
                return view('userpage');
            }
            return view('userpage');
        }else{
            return view('home');
        }
    }
    public function addchild($id){
        Session::put('line_code',$id);
        $getpic = new Student;
        $queryresult = DB::table('students')
        ->select(DB::raw('local_pic'))
        ->where('line_code' , $id)
        ->get();
        $arrayresult = json_decode($queryresult, true);
        $result = $arrayresult[0]["local_pic"];
        Session::put('local_pic',$result);
        return redirect('/addchild')->with('code',$id);
    }

}
