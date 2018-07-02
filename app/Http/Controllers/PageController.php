<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Pagecontroller extends Controller
{
    public function getLaravelpage(){
        return view('welcome');
    }
    public function addchildpage(){
        return view('addchild');
    }
    public function getchoosepage(){
      //require picture,name
      return view('choose');
    }
    public function getsteppage(){
      return view('step');
    }
    public function getuserpage(){
      //require line_code ChooseChild
      return view('userpage');
    }
    public function gethome(){
        if(session()->has('username')){
            $id = session('id', 'default');
            // query child
            $jsonresult = DB::table('students')
            ->rightjoin('studentparents','students.line_code','=','studentparents.line_code')
            ->leftjoin('managers','studentparents.parent_id','=','managers.id')
            ->select(DB::raw('students.line_code,students.local_pic'))
            ->where('studentparents.parent_id',$id)
            ->get();
            $arrayresult = json_decode($jsonresult, true);
            $countchild = count($jsonresult);
            Session::put('countchild',$countchild);
            if($countchild==0){
                return redirect('/step');
            }elseif($countchild==1){
                Session::put('childdata',$arrayresult);
                return redirect('/userpage');
            }elseif($countchild>=2){
                Session::put('childdata',$arrayresult);
                return redirect('/choose');
            }else{
                return redirect('/step');
            }

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
