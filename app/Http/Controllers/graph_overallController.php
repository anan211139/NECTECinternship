<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class graph_overallController extends Controller
{
    public function main($id){
      $choosechild = $id;
      $jsonsubject = DB::table('subjects')->get();
      $jsonchapters = DB::table('chapters')->get();
      $jsonchooeschilddata = DB::table('students')->where('line_code','=',$choosechild)->get();
      $arraysubject = json_decode($jsonsubject, true);
      $arraychapters = json_decode($jsonchapters, true);
      $arraychooeschilddata  = json_decode($jsonchooeschilddata, true);
      // return $jsonchooeschilddata;
      Session::put('subject_list',$arraysubject);
      Session::put('chapter_list',$arraychapters);
      Session::put('choosechild',$choosechild);
      Session::put('choosechilddata',$arraychooeschilddata);
      if(session()->has('student_score')){
        session()->forget('student_score');
        session()->forget('score_above');
        session()->forget('score_below');
        session()->forget('pie_outside');
        session()->forget('pie_inside');
      }
      if(session()->has('student_score_chapter')){
        session()->forget('student_score_chapter');
        session()->forget('overall_score');
        session()->forget('student_count');
        session()->forget('level_total');
        session()->forget('level_true');
      }
      $student_score_allsubject = DB::table('results')
      ->select(DB::raw('subjects.name as name,sum(total_level_true*level_id) as score'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->where('groups.line_code', '=', $choosechild)
      ->groupBy('chapters.subject_id')
      ->orderBy('results.group_id', 'asc')
      ->get(); //คะเเนนนักเรียน เศษ
      // $student_score_allsubject = json_decode($student_score_allsubject, true);
      // return $student_score_allsubject;
      $student_score_count = DB::table('results')
      ->select(DB::raw('count(level_id) as count'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->where('level_id', '=', 2)
      ->where('groups.line_code', '=',$choosechild)
      ->groupBy('chapters.subject_id')
      ->orderBy('group_id', 'asc')
      ->get(); //คะเเนนนักเรียน ส่วน
      // $student_score_count = json_decode($student_score_count, true);
      // return $student_score_count;
      $overall_score = DB::table('results')                                       //edit me
      ->select(DB::raw('sum(total_level_true*level_id) as overall'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->groupBy('chapters.subject_id')
      ->orderBy('chapters.subject_id', 'asc')
      ->get(); //รวมวิชา คะเเนนรวม เศษ (เอาไปบวกกับคะแนนนักเรียนที่ได้)
      // return $overall_score;
      $student_count = DB::table('groups')
      ->select(DB::raw('count(groups.id) as student_count'))
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->groupBy('chapters.subject_id')
      ->get(); //จำนวนนักเรียนที่ทำในแต่ละวิชา
      // return $student_count;
      $pie_inside = DB::table('results')
       ->select(DB::raw('sum(total_level)as inside'))
       ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
       ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
       ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
       ->where('groups.line_code','=', $choosechild)
       ->groupBy('chapters.subject_id')
       ->get();
       // ได้ทำ
       // return $pie_inside;
      $pie_outside =DB::table('results')
       ->select(DB::raw('sum(total_level_true)as outside'))
       ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
       ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
       ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
       ->where('groups.line_code','=', $choosechild)
       ->groupBy('chapters.subject_id')
       ->get();
        // ข้อที่ทำได้
      // return $pie_outside;
      $sumoverall = DB::table('results')
      ->select(DB::raw('sum(total_level) as max,sum(total_level_true) as `true`'))
      ->leftjoin('groups','results.group_id','=','groups.id')
      ->where('groups.line_code','=',$choosechild)
      ->get();
       // countรวมทุกวิชา(ข้อ)จำนวนถูกและเต็ม
      // return $sumoverall;
      $sumsub1 = DB::table('results')
      ->select(DB::raw('sum(total_level) as max,sum(total_level_true) as `true`'))
      ->leftjoin('groups','results.group_id','=','groups.id')
      ->leftjoin('chapters','groups.chapter_id','=','chapters.id')
      ->where('groups.line_code','=',$choosechild)
      ->where('chapters.subject_id','=','1')
      ->get();
      $sumsub12 = DB::table('results')
      ->select(DB::raw('sum(total_level) as max,sum(total_level_true) as `true`'))
      ->leftjoin('groups','results.group_id','=','groups.id')
      ->leftjoin('chapters','groups.chapter_id','=','chapters.id')
      ->where('groups.line_code','=',$choosechild)
      ->where('chapters.subject_id','=','2')
      ->get();

        Session::put('student_score_allsubject',$student_score_allsubject);
        Session::put('student_score_count',$student_score_count);
        Session::put('overall_score',$overall_score);
        Session::put('student_count',$student_count);
        // Session::put('pie_inside',$pie_inside);
        // Session::put('pie_outside',$pie_outside);
        Session::put('sumoverall',$sumoverall);
        Session::put('sumsub1',$sumsub1);
        Session::put('sumsub2',$sumsub12);

        return redirect('/userpage');
        // ->with('student_score_allsubject', $student_score_allsubject)
        // ->with('student_score_count', $student_score_count)
        // ->with('overall_score', $overall_score)
        // ->with('student_count', $student_count)
        // ->with('pie_inside', $pie_inside)
        // ->with('pie_outside', $pie_outside)
        // ->with('overall', 'overall');
    }
}
