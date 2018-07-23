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
      if(session()->has('username')){
      return view('choose');
      }else{
        return redirect('/');
      }
    }
    public function getsteppage(){
      if(session()->has('username')){
      $childdata = session('childdata','default');
      return view('step');
      }else{
        return redirect('/');
      }
    }
    public function getuserpage(){
      if(session()->has('choosechild')){
        $jsonsubject = DB::table('subjects')->get();
        $jsonchapters = DB::table('chapters')->get();
        $arraysubject = json_decode($jsonsubject, true);
        $arraychapters = json_decode($jsonchapters, true);
        Session::put('subject_list',$arraysubject);
        Session::put('chapter_list',$arraychapters);
        // return $arraychapters;
        // $line_code = 'st11';
        return view('userpage');
      }else{
        return redirect('/');
      }
    }
    public function gethome(){
        if(session()->has('username')){
            $id = session('id', 'default');
            // query child
            $jsonresult = DB::table('students')
            ->rightjoin('studentparents','students.line_code','=','studentparents.line_code')
            ->leftjoin('managers','studentparents.parent_id','=','managers.id')
            ->select(DB::raw('students.line_code,students.local_pic,students.name'))
            ->where('studentparents.parent_id',$id)
            ->get();
            $arrayresult = json_decode($jsonresult, true);
            $countchild = count($jsonresult);
            Session::put('childdata',$arrayresult);
            Session::put('countchild',$countchild);
            if($countchild==0){
                return redirect('/step');
            }elseif($countchild==1){
                Session::put('childdata',$arrayresult);
                Session::put('choosechild',$arrayresult[0]['line_code']);
                return redirect('/selectoverall');
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
