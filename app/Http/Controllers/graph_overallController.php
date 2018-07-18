<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Graph;

class graph_allsubjectController extends Controller
{
    public function index()
    {
      $line_code = 'st11';
      // รวมทุกวิชา
      $student_score_allsubject = DB::table('results')
      ->select(DB::raw('subject.name as name,sum(total_level_true*level_id) as score'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('subject', 'subject.id', '=', 'subject_id')
      ->where('results.line_code', '=', $line_code)
      ->groupBy('subject_id')
      ->orderBy('group_id', 'asc')
      ->get(); //คะเเนนนักเรียน เศษ

      $student_score_count = DB::table('results')
      ->select(DB::raw('count(level_id) as count'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->where('level_id', '=', 2)
      ->where('results.line_code', '=',$line_code)
      ->groupBy('subject_id')
      ->orderBy('group_id', 'asc')
      ->get(); //คะเเนนนักเรียน ส่วน

      $overall_score = DB::table('results')
      ->select(DB::raw('sum(total_level_true*level_id) as overall'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->where('results.line_code', '!=', $line_code)
      ->groupBy('subject_id')
      ->orderBy('group_id', 'asc')
      ->get(); //รวมวิชา คะเเนนรวม เศษ (เอาไปบวกกับคะแนนนักเรียนที่ได้)

      $student_count = DB::table('results')
      ->select(DB::raw('count(distinct results.line_code) as student_count'))
      ->leftjoin('groups', 'groups.id','=','results.group_id')
      ->groupBy('subject_id')
      ->get(); //จำนวนนักเรียนที่ทำในแต่ละวิชา

       $pie_inside = DB::table('results')
       ->select(DB::raw('sum(total_level)as inside'))
       ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
       ->where('results.line_code','=', $line_code)
       ->groupBy('subject_id')
       ->get(); //ได้ทำ

       $pie_outside =DB::table('results')
       ->select(DB::raw('sum(total_level_true)as outside'))
       ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
       ->where('results.line_code','=', $line_code)
       ->groupBy('subject_id')
       ->get(); //ข้อที่ทำได้

      return view('graph_allsubject')
      ->with('student_score_allsubject', $student_score_allsubject)
      ->with('student_score_count', $student_score_count)
      ->with('overall_score', $overall_score)
      ->with('student_count', $student_count)
      ->with('pie_inside', $pie_inside)
      ->with('pie_outside', $pie_outside);




    }
}
