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
        // return $student_count;
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
        // return $level_total;
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
        // return $level_true;
        Session::put('student_score_chapter',$student_score_chapter);
        Session::put('overall_score',$overall_score);
        Session::put('student_count',$student_count);
        Session::put('level_total',$level_total);
        Session::put('level_true',$level_true);

        // ของวิชา
        $student_score = DB::table(DB::raw("(select chapter_id as id,count(level_id) as num from results
                                  	left join groups on results.group_id = groups.id
                                  	left join chapters on groups.chapter_id = chapters.id
                                  	where chapters.subject_id = '$subject_id' and level_id = 2 and groups.line_code = '$line_code'
                                  	group by chapter_id
                                  	order by chapter_id asc) coun"))
        ->select(DB::raw('chapters.name,sum(score)/num as score'))
        ->rightjoin('groups', 'coun.id', '=', 'groups.chapter_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id' )
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get();
        //bar chart คะแนนนักรียน กราฟรายวิชา
        // return $student_score;
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
        $pie_outside = DB::table('results')
        ->select(DB::raw('sum(total_level_true)as pie_outside'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get(); //pie chart ข้อที่ทำได้ กราฟรายวิชา
        // return $pie_outside;
        $pie_inside = DB::table('results')
        ->select(DB::raw('sum(total_level)as pie_inside'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get();//pie chart ข้อที่ได้ทำ กราฟรายวิชา
        // return $pie_inside;
        Session::put('student_score',$student_score);
        Session::put('above',$score_above);
        Session::put('below',$score_below);
        Session::put('pie_outside',$pie_outside);
        Session::put('pie_inside',$pie_inside);


        return redirect('/userpage');
          // ->with('student_score_chapter',$student_score_chapter)
          // ->with('overall_score', $overall_score)
          // ->with('student_count',$student_count)
          // ->with('level_total', $level_total)
          // ->with('level_true',$level_true)
          // ->with('chapter', 'chapter');
    }
}
