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
        $jsonsubject = DB::table('subjects')->get();
        $jsonchapters = DB::table('chapters')->get();
        $arraysubject = json_decode($jsonsubject, true);
        $arraychapters = json_decode($jsonchapters, true);
        Session::put('subject_list',$arraysubject);
        Session::put('chapter_list',$arraychapters);
        // return $arraychapters;
        // $line_code = 'st11';
        return view('userpage');
    }
    public function dashboard(){
      if(session()->has('username')){
        $id = session('id', 'default');
        // query child
        $jsonresult = DB::table('students')
        ->leftjoin('studentparents','students.line_code','=','studentparents.line_code')
        ->leftjoin('managers','studentparents.parent_id','=','managers.id')
        ->select(DB::raw('students.line_code,students.local_pic,students.name'))
        ->where('studentparents.parent_id',$id)
        ->orderBy('students.name','asc')
        ->get();
        $arrayresult = json_decode($jsonresult, true);
        Session::put('childdata',$arrayresult);

        // $student_mean_sub1 = DB::table('groups')
        // ->leftjoin('chapters', 'chapter_id', '=', 'chapters.id')
        // ->leftjoin('subjects', 'subject_id', '=', 'subjects.id')
        // ->leftjoin('studentparents','groups.line_code','=','studentparents.line_code')
        // ->rightjoin('students','groups.line_code','=','students.line_code')
        // ->select(DB::raw('students.name,subjects.name as subject_name, sum(score) / count(score) as mean'))
        // ->where('parent_id', '=', $id )
        // ->where('subject_id', '=', '1' )
        // ->groupBy('groups.line_code')
        // ->get();
        // $arrayresult = json_decode($student_mean_sub1, true);
        // Session::put('sub1',$arrayresult);
        //
        // $student_mean_sub2 = DB::table('groups')
        // ->select(DB::raw('students.name,subjects.name as subject_name, sum(score) / count(score) as mean'))
        // ->leftjoin('chapters', 'chapter_id', '=', 'chapters.id')
        // ->leftjoin('subjects', 'subject_id', '=', 'subjects.id')
        // ->leftjoin('studentparents','groups.line_code','=','studentparents.line_code')
        // ->rightjoin('students','groups.line_code','=','students.line_code')
        // ->where('parent_id', '=', $id )
        // ->where('subject_id', '=', '2' )
        // ->groupBy('groups.line_code')
        // ->orderBy('students.name','asc')
        // ->get();
        // $arrayresult = json_decode($student_mean_sub2, true);
        // Session::put('sub2',$arrayresult);

        $meanoverall = DB::table(DB::raw("(select groups.line_code,subjects.name,sum(score) / count(score) as score from groups
                                          left join chapters on chapter_id = chapters.id
                                          left join subjects on subject_id = subjects.id
                                          left join studentparents on groups.line_code = studentparents.line_code
                                          where subject_id = 1 and parent_id = $id
                                          group by groups.line_code -- mean_subject
                                          order by groups.id) total"))
        ->select(DB::raw('sum(score) / count(score) as mean'))
        ->get();
        $arrayresult = json_decode($meanoverall, true);
        Session::put('meansub1',$arrayresult);
        $meanoverall2 = DB::table(DB::raw("(select groups.line_code,subjects.name,sum(score) / count(score) as score from groups
                                          left join chapters on chapter_id = chapters.id
                                          left join subjects on subject_id = subjects.id
                                          left join studentparents on groups.line_code = studentparents.line_code
                                          where subject_id = 2 and parent_id = $id
                                          group by groups.line_code -- mean_subject
                                          order by groups.id) total"))
        ->select(DB::raw('sum(score) / count(score) as mean'))
        ->get();
        $arrayresult = json_decode($meanoverall2, true);
        Session::put('meansub2',$arrayresult);
        return view('dashboard');
      }
    }
    public function gethome(){
        if(session()->has('username')){
            return redirect('/dashboard');
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
