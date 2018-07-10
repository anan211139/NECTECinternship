<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete exams table records
         DB::table('exams')->delete();
         //insert some dummy records
         DB::table('exams')->insert(array(
             array('subject_id'=>1,'chapter_id'=>1,'level_id'=>2,'local_pic'=>'img/exam/Math/Equation/eq01_med_3.png','answer'=>3,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>1,'level_id'=>1,'local_pic'=>'img/exam/Math/Equation/eq02_easy_2.png','answer'=>2,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>1,'level_id'=>3,'local_pic'=>'img/exam/Math/Equation/eq03_hard_3.png','answer'=>3,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>1,'level_id'=>3,'local_pic'=>'img/exam/Math/Equation/eq04_hard_2.png','answer'=>2,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>2,'level_id'=>3,'local_pic'=>'img/exam/Math/GCD/GCD01_hard_3.png','answer'=>3,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>2,'level_id'=>2,'local_pic'=>'img/exam/Math/GCD/GCD01_med_1.png','answer'=>1,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>2,'level_id'=>3,'local_pic'=>'img/exam/Math/GCD/GCD01_hard_1.png','answer'=>1,'principle_id'=>1),
             array('subject_id'=>1,'chapter_id'=>2,'level_id'=>1,'local_pic'=>'img/exam/Math/GCD/GCD01_easy_1.png','answer'=>1,'principle_id'=>1),
          ));
    }
}
