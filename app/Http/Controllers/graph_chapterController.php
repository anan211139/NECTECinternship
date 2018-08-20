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
        $jsonsubject = DB::table('subjects')->get();
        $jsonchapters = DB::table('chapters')->get();
        $chapterCh = DB::table('chapters')->where('id',$chapter_id)->select('name')->get();
        $arraysubject = json_decode($jsonsubject, true);
        $arraychapters = json_decode($jsonchapters, true);
        $chapterCh = json_decode($chapterCh, true);
        Session::put('subject_list',$arraysubject);
        Session::put('chapter_list',$arraychapters);
        Session::put('chapterCh',$chapterCh);
        if(session()->has('student_score_allsubject')){
          session()->forget('student_score_allsubject');
          session()->forget('student_score_count');
          session()->forget('overall_score');
          session()->forget('student_count');
          session()->forget('pie_inside');
          session()->forget('pie_outside');
        }
        if(session()->has('student_score')){
          session()->forget('student_score');
          session()->forget('score_above');
          session()->forget('score_below');
          session()->forget('pie_outside');
          session()->forget('pie_inside');
        }
    // แต่ละบท
    // $test = DB::table('groups')                                                         คะแนนชุดล่าสุด
    // ->select('id','score')
    // ->where('status','=','1')
    // ->where('line_code','=',$line_code)
    // ->where('chapter_id','=',$chapter_id)
    // ->orderBy('updated_at','desc')
    // ->limit(2)
    // ->get();
    // return $test;
        $sumoverall = DB::table('results')
        ->select(DB::raw('sum(total_level) as max,sum(total_level_true) as `true`'))
        ->leftjoin('groups','results.group_id','=','groups.id')
        ->where('groups.line_code','=',$line_code)
        ->get();
         // countรวมทุกวิชา(ข้อ)จำนวนถูกและเต็ม
        // return $sumoverall;
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
        // return $overall_score;
        $student_count = DB::table('results')
        ->select(DB::raw('count(distinct groups.line_code) as count'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', 1)
        ->where('chapters.id', '=', 1)
        ->groupBy('chapter_id')
        ->get(); //นับจะนวนเด็กที่ทำ
        // return $student_count
        $extenlevel = DB::table(DB::raw("(select chapter_id,id as group_id from groups where status = 1 and chapter_id = '$chapter_id' and line_code = '$line_code' limit 1) lastgroup"))
        ->join('groups','lastgroup.group_id','=','groups.id')
        ->leftjoin('results','groups.id','=','results.group_id')
        ->leftjoin('chapters','groups.chapter_id','=','chapters.id')
        ->select('results.level_id','results.total_level','results.total_level_true')
        ->get();
        // return $extenlevel;
        $chapterstatus = DB::table('chapters')->where('id','=',$chapter_id)->get();
        // return $chapterstatus;
        // $level_total = DB::table('results')
        // ->select(DB::raw('levels.name as level_name, results.total_level as level_total'))
        // ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        // ->leftjoin('levels', 'results.level_id', '=', 'levels.id')
        // ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        // ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        // ->where('subject_id', '=', $subject_id )
        // ->where('chapter_id', '=', $chapter_id )
        // ->where('groups.line_code', '=', $line_code )
        // ->get(); //ข้อที่ได้ทำในแต่ละระดับ
        // // return $level_total;
        // $level_true = DB::table('results')
        // ->select(DB::raw('levels.name as level_name,total_level_true as level_true'))
        // ->leftjoin('groups', 'group_id', '=', 'groups.id')
        // ->leftjoin('levels', 'results.level_id', '=', 'levels.id')
        // ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        // ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        // ->where('subject_id', '=', $subject_id )
        // ->where('chapter_id', '=', $chapter_id )
        // ->where('groups.line_code', '=', $line_code )
        // ->get(); //ข้อที่ทำได้ในแต่ละระดับ
        // return $level_true;
        Session::put('student_score_chapter',$student_score_chapter);
        Session::put('overall_score',$overall_score);
        Session::put('student_count',$student_count);
        // Session::put('level_total',$level_total);
        // Session::put('level_true',$level_true);
        Session::put('chapterstatus',$chapterstatus);
        Session::put('extenlevel',$extenlevel);

        return redirect('/userpage');
          // ->with('student_score_chapter',$student_score_chapter)
          // ->with('overall_score', $overall_score)
          // ->with('student_count',$student_count)
          // ->with('level_total', $level_total)
          // ->with('level_true',$level_true)
          // ->with('chapter', 'chapter');
    }
}
