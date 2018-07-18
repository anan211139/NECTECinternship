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
        $choosechild = session('choosechild', 'default');
        // return $arraychapters;
        // $line_code = 'st11';
        // รวมทุกวิชา
        $student_score_allsubject = DB::table('results')
        ->select(DB::raw('subjects.name as name,sum(total_level_true*level_id) as score'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('results.line_code', '=', '$choosechild')
        ->groupBy('chapters.subject_id')
        ->orderBy('results.group_id', 'asc')
        ->get(); //คะเเนนนักเรียน เศษ
        return $student_score_allsubject;
        $student_score_count = DB::table('results')
        ->select(DB::raw('count(level_id) as count'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->where('level_id', '=', 2)
        ->where('results.line_code', '=',$choosechild)
        ->groupBy('groups.subject_id')
        ->orderBy('group_id', 'asc')
        ->get(); //คะเเนนนักเรียน ส่วน

        $overall_score = DB::table('results')
        ->select(DB::raw('sum(total_level_true*level_id) as overall'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->where('results.line_code', '!=', $choosechild)
        ->groupBy('groups.subject_id')
        ->orderBy('group_id', 'asc')
        ->get(); //รวมวิชา คะเเนนรวม เศษ (เอาไปบวกกับคะแนนนักเรียนที่ได้)

        $student_count = DB::table('results')
        ->select(DB::raw('count(distinct results.line_code) as student_count'))
        ->leftjoin('groups', 'groups.id','=','results.group_id')
        ->groupBy('groups.subject_id')
        ->get(); //จำนวนนักเรียนที่ทำในแต่ละวิชา

         $pie_inside = DB::table('results')
         ->select(DB::raw('sum(total_level)as inside'))
         ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
         ->where('results.line_code','=', $choosechild)
         ->groupBy('groups.subject_id')
         ->get(); //ได้ทำ

         $pie_outside =DB::table('results')
         ->select(DB::raw('sum(total_level_true)as outside'))
         ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
         ->where('results.line_code','=', $choosechild)
         ->groupBy('groups.subject_id')
         ->get(); //ข้อที่ทำได้

        return view('userpage')
        ->with('student_score_allsubject', $student_score_allsubject)
        ->with('student_score_count', $student_score_count)
        ->with('overall_score', $overall_score)
        ->with('student_count', $student_count)
        ->with('pie_inside', $pie_inside)
        ->with('pie_outside', $pie_outside);
        // return view('userpage');
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
