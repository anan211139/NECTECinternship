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
        // ของวิชา
        public $student_score = DB::table('results')
        ->select(DB::raw('chapters.name,sum(total_level_true*level_id) as score'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id' )
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get(); //bar chart คะแนนนักรียน กราฟรายวิชา

        public $score_above = DB::table('results')
        ->select(DB::raw('sum(total_level_true*level_id) as above'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id' )
        ->where('chapters.subject_id', '=', $subject_id)
        ->groupBy('chapter_id')
        ->orderBy('group_id', 'asc')
        ->get(); //bar chart คะแนนนoverall กราฟรายวิชา (เศษ)

        public $score_below = DB::table('results')
        ->select(DB::raw('count(level_id) as below'))
        ->leftjoin('groups', 'results.group_id', '=', 'groups.id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('level_id', '=', '2')
        ->where('chapters.subject_id', '=', $subject_id)
        ->groupBy('chapters.id')
        ->orderBy('group_id', 'asc')
        ->get(); //bar chart คะแนนนoverall กราฟรายวิชา (ส่วน)

        public $pie_outside = DB::table('results')
        ->select(DB::raw('sum(total_level_true)as pie_outside'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get(); //pie chart ข้อที่ทำได้ กราฟรายวิชา

        public $pie_inside = DB::table('results')
        ->select(DB::raw('sum(total_level)as pie_inside'))
        ->leftjoin('groups', 'groups.id', '=', 'results.group_id')
        ->leftjoin('chapters', 'groups.chapter_id', '=', 'chapters.id')
        ->leftjoin('subjects', 'chapters.subject_id', '=', 'subjects.id')
        ->where('chapters.subject_id', '=', $subject_id)
        ->where('groups.line_code', '=', $line_code)
        ->groupBy('chapter_id')
        ->get();//pie chart ข้อที่ได้ทำ กราฟรายวิชา

        return view('userpage')
        ->with('student_score',$student_score)
        ->with('above',$score_above)
        ->with('below', $score_below)
        ->with('pie_outside', $pie_outside)
        ->with('pie_inside', $pie_inside)
        ->with('subject', 'subject');
    }
}
