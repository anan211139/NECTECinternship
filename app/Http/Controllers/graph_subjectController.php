<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Graph;

class graphController extends Controller
{
    //
    public function index(){
      $line_code = 'st11';
      $subject_id = 1;
      // ของวิชา
      $student_score = DB::table('results')
      ->select(DB::raw('chapters.name,sum(total_level_true*level_id) as score'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id' )
      ->where('subject_id', '=', $subject_id)
      ->where('results.line_code', '=', $line_code)
      ->groupBy('chapter_id')
      ->get(); //bar chart คะแนนนักรียน กราฟรายวิชา

      $score_above = DB::table('results')
      ->select(DB::raw('sum(total_level_true*level_id) as above'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->where('subject_id', '=', $subject_id)
      ->groupBy('chapter_id')
      ->orderBy('group_id', 'asc')
      ->get(); //bar chart คะแนนนoverall กราฟรายวิชา (เศษ)

      $score_below = DB::table('results')
      ->select(DB::raw('count(level_id) as below'))
      ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
      ->where('level_id', '=', '2')
      ->where('subject_id', '=', $subject_id)
      ->groupBy('chapter_id')
      ->orderBy('group_id', 'asc')
      ->get(); //bar chart คะแนนนoverall กราฟรายวิชา (ส่วน)

      $pie_outside = DB::table('results')
      ->select(DB::raw('sum(total_level_true)as pie_outside'))
      ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
      ->where('subject_id', '=', $subject_id)
      ->where('results.line_code', '=', $line_code)
      ->groupBy('chapter_id')
      ->get(); //pie chart ข้อที่ทำได้ กราฟรายวิชา

      $pie_inside = DB::table('results')
      ->select(DB::raw('sum(total_level)as pie_inside'))
      ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
      ->where('subject_id', '=', $subject_id)
      ->where('results.line_code', '=', $line_code)
      ->groupBy('chapter_id')
      ->get();//pie chart ข้อที่ได้ทำ กราฟรายวิชา

      return view('graph')
      ->with('student_score',$student_score)
      ->with('above',$score_above)
      ->with('below', $score_below)
      ->with('pie_outside', $pie_outside)
      ->with('pie_inside', $pie_inside);


    }
}
