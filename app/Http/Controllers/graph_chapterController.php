<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class graph_chapterController extends Controller
{
  public function index()
  {
    $line_code = 'st11';
    $chapter_id = '1';
    $subject_id = '1';
// แต่ละบท
    $student_score_chapter = DB::table('results')
    ->select(DB::raw('chapters.name as chapter_name,sum(level_id * total_level_true) as score'))
    ->leftjoin('groups','results.group_id', '=','groups.id')
    ->leftjoin('chapters','chapter_id', '=', 'chapters.id')
    ->where('subject_id','=',$subject_id)
    ->where('chapter_id', '=', $chapter_id)
    ->where('results.line_code', '=', $line_code)
    ->groupBy('group_id')
    ->get(); //คะแนนเด็ก

    $overall_score = DB::table('results')
    ->select(DB::raw('sum(level_id * total_level_true) as score'))
    ->leftjoin('groups','results.group_id', '=','groups.id')
    ->where('subject_id','=',$subject_id)
    ->where('chapter_id', '=', $chapter_id)
    ->get(); //คะแนนบาร์ชาตรวม

    $student_count = DB::table('results')
    ->select(DB::raw('count(distinct results.line_code) as count'))
    ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
    ->where('subject_id', '=', 1)
    ->where('chapter_id', '=', 1)
    ->groupBy('chapter_id')
    ->get(); //นับจะนวนเด็กที่ทำ

    $level_total = DB::table('results')
    ->select(DB::raw('levels.name as level_name, total_level as level_total'))
    ->leftjoin('groups', 'group_id', '=', 'groups.id')
    ->leftjoin('levels', 'level_id', '=', 'levels.id')
    ->where('subject_id', '=', $subject_id )
    ->where('chapter_id', '=', $chapter_id )
    ->where('results.line_code', '=', $line_code )
    ->groupBy('level_id')
    ->get(); //ข้อที่ได้ทำในแต่ละระดับ

    $level_true = DB::table('results')
    ->select(DB::raw('total_level_true as level_true'))
    ->leftjoin('groups', 'group_id', '=', 'groups.id')
    ->where('subject_id', '=', $subject_id )
    ->where('chapter_id', '=', $chapter_id )
    ->where('results.line_code', '=', $line_code )
    ->get(); //ข้อที่ทำได้ในแต่ละระดับ


    return view('graph_chapter')
    ->with('student_score_chapter',$student_score_chapter)
    ->with('overall_score', $overall_score)
    ->with('student_count',$student_count)
    ->with('level_total', $level_total)
    ->with('level_true',$level_true);
  }
}
