<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class graph_subjectController extends Controller
{
    public function main($id){
        $line_code = session('choosechild','default');
        $subject_id = $id;

        if(session()->has('student_score_allsubject')){
          session()->forget('student_score_allsubject');
          session()->forget('student_score_count');
          session()->forget('overall_score');
          session()->forget('student_count');
          session()->forget('pie_inside');
          session()->forget('pie_outside');
        }
        if(session()->has('student_score_chapter')){
          session()->forget('student_score_chapter');
          session()->forget('overall_score');
          session()->forget('student_count');
          session()->forget('level_total');
          session()->forget('level_true');
        }

        // ของวิชา
        $student_score = DB::table('results')                                           //พังจ้าาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาา
        ->select(DB::raw('chapters.name,sum(total_level_true*level_id) as score'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get(); //bar chart คะแนนนักรียน กราฟรายวิชา
        // return $student_score;
        $countstudent_score = DB::table('results')
        ->select(DB::raw('count(group_id) as count'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->where('level_id','=','2')
        ->groupBy('chapter_id')
        ->get();
        // นับจำนวนชุดในแต่ละบท
        // return $countstudent_score;
        $score_above = DB::table('results')
        ->select(DB::raw('sum(total_level_true*level_id) as above'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id' )
        ->where('chapters.subject_id', '=', $subject_id)
        ->groupBy('chapter_id')
        ->orderBy('group_id', 'asc')
        ->get(); //bar chart คะแนนนoverall กราฟรายวิชา (เศษ)
        // return $score_above;
        $score_below = DB::table('results')
        ->select(DB::raw('count(level_id) as below'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('level_id', '=', '2')
        ->where('chapters.subject_id', '=', $subject_id)
        ->groupBy('chapters.id')
        ->orderBy('group_id', 'asc')
        ->get(); //bar chart คะแนนนoverall กราฟรายวิชา (ส่วน)
        // return $score_below;
        $scorechapter = DB::table('results')
        ->select(DB::raw('sum(total_level_true)as score'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get(); //pie chart ข้อที่ทำได้ กราฟรายวิชา
        // return $pie_outside;
        $maxchapter = DB::table('results')
        ->select(DB::raw('sum(total_level)as max,groups.chapter_id as id'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get();//pie chart ข้อที่ได้ทำ กราฟรายวิชา
        // return $pie_inside;

        $sumoverall = DB::table('results')
        ->select(DB::raw('sum(total_level) as max,sum(total_level_true) as `true`'))
        ->leftjoin('groups','results.group_id','=','groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->where('groups.line_code','=',$line_code)
        ->where('chapters.subject_id','=',$subject_id)
        ->get();
        // return $sumoverall;
        Session::put('student_score',$student_score);
        Session::put('above',$score_above);
        Session::put('below',$score_below);
        Session::put('scorechapter',$scorechapter);
        Session::put('maxchapter',$maxchapter);


        Session::put('subject_status',$subject_id);
        Session::put('countgroups',$countstudent_score);
        Session::put('sumoverall',$sumoverall);
        return redirect('/userpage');
        // return view('userpage')
        // ->with('student_score',$student_score)
        // ->with('above',$score_above)
        // ->with('below', $score_below)
        // ->with('pie_outside', $pie_outside)
        // ->with('pie_inside', $pie_inside)
        // ->with('subject', 'subject');
    }
}
