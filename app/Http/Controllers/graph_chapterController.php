<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class graph_chapterController extends Controller
{
    public function main($subject,$chapter){
        $line_code = session('choosechild','default');
        $chapter_id = $chapter;
        $subject_id = $subject;
    // แต่ละบท
        $student_score_chapter = DB::table('results')
        ->select(DB::raw('chapters.name as chapter_name,sum(level_id * total_level_true) as score'))
        ->leftjoin('groups','results.group_id', '=','groups.id')
        ->leftjoin('chapters','chapter_id', '=', 'chapters.id')
        ->where('subject_id','=',$subject_id)
        ->where('chapter_id', '=', $chapter_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('group_id')
        ->get(); //คะแนนเด็ก
        // return $student_score_chapter;
        $overall_score = DB::table('results')
        ->select(DB::raw('sum(level_id * total_level_true) as score'))
        ->leftjoin('groups','results.group_id', '=','groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id','=',$subject_id)
        ->where('chapters.id', '=', $chapter_id)
        ->get(); //คะแนนบาร์ชาตรวม

        $student_count = DB::table('results')
        ->select(DB::raw('count(distinct groups.line_code) as count'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', 1)
        ->where('chapters.id', '=', 1)
        ->groupBy('chapter_id')
        ->get(); //นับจะนวนเด็กที่ทำ

        $level_total = DB::table('results')
        ->select(DB::raw('levels.name as level_name, results.total_level as level_total'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('levels', 'results.level_id', '=', 'levels.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('subject_id', '=', $subject_id )
        ->where('chapter_id', '=', $chapter_id )
        ->where('groups.line_code', '=', $line_code )
        ->groupBy('results.level_id')
        ->get(); //ข้อที่ได้ทำในแต่ละระดับ

        $level_true = DB::table('results')
        ->select(DB::raw('levels.name as level_name,total_level_true as level_true'))
        ->leftjoin('groups', 'group_id', '=', 'groups.id')
        ->leftjoin('levels', 'results.level_id', '=', 'levels.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('subject_id', '=', $subject_id )
        ->where('chapter_id', '=', $chapter_id )
        ->where('groups.line_code', '=', $line_code )
        ->get(); //ข้อที่ทำได้ในแต่ละระดับ

        return view('userpage')
        ->with('student_score_chapter',$student_score_chapter)
        ->with('overall_score', $overall_score)
        ->with('student_count',$student_count)
        ->with('level_total', $level_total)
        ->with('level_true',$level_true)
        ->with('chapter', 'chapter');
    }
}
