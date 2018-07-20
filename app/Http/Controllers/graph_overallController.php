<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class graph_overallController extends Controller
{
    public $student_score_allsubject,$student_score_count,$overall_score,$student_count,$pie_inside,$pie_outside;
    public function main(){
      $student_score_allsubject = DB::table('results')
      ->select(DB::raw('subjects.name as name,sum(total_level_true*level_id) as score'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->where('groups.line_code', '=', '$choosechild')
      ->groupBy('chapters.subject_id')
      ->orderBy('results.group_id', 'asc')
      ->get(); //คะเเนนนักเรียน เศษ
      // return $student_score_allsubject;
      $student_score_count = DB::table('results')
      ->select(DB::raw('count(level_id) as count'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->where('level_id', '=', 2)
      ->where('groups.line_code', '=','$choosechild')
      ->groupBy('chapters.subject_id')
      ->orderBy('group_id', 'asc')
      ->get(); //คะเเนนนักเรียน ส่วน
      // return $student_score_count;
      $overall_score = DB::table('results')
      ->select(DB::raw('sum(total_level_true*level_id) as overall'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->where('groups.line_code', '!=', '$choosechild')
      ->groupBy('chapters.subject_id')
      ->orderBy('group_id', 'asc')
      ->get(); //รวมวิชา คะเเนนรวม เศษ (เอาไปบวกกับคะแนนนักเรียนที่ได้)
      // return $overall_score;
      $student_count = DB::table('results')
      ->select(DB::raw('count(distinct groups.line_code) as student_count'))
      ->leftjoin('groups', 'groups.id','=','results.group_id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
      ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
      ->groupBy('chapters.subject_id')
      ->get(); //จำนวนนักเรียนที่ทำในแต่ละวิชา
      // return $student_count;
      $pie_inside = DB::table('results')
       ->select(DB::raw('sum(total_level)as inside'))
       ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
       ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
       ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
       ->where('groups.line_code','=', '$choosechild')
       ->groupBy('chapters.subject_id')
       ->get(); //ได้ทำ
       // return $pie_inside;
      $pie_outside =DB::table('results')
       ->select(DB::raw('sum(total_level_true)as outside'))
       ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
       ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
       ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
       ->where('groups.line_code','=', '$choosechild')
       ->groupBy('chapters.subject_id')
       ->get(); //ข้อที่ทำได้
      // return $pie_outside;
        return view('userpage')
        ->with('student_score_allsubject', $student_score_allsubject)
        ->with('student_score_count', $student_score_count)
        ->with('overall_score', $overall_score)
        ->with('student_count', $student_count)
        ->with('pie_inside', $pie_inside)
        ->with('pie_outside', $pie_outside)
        ->with('overall', 'overall');
    }
}
