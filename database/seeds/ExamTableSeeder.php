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
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq02_easy_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq03_hard_3.png', 'answer'=> 3 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq13_med_1.png', 'answer'=> 1 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq17_easy_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq18_easy_1.png', 'answer'=> 1 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq19_easy_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq25_easy_1.png', 'answer'=> 1 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq29_easy_1.png', 'answer'=> 1 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq30_easy_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq31_easy_1.png', 'answer'=> 1 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq32_easy_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq32_med_3.png', 'answer'=> 3 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq39_hard_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD01_hard_3.png', 'answer'=> 3 , 'principle_id'=> 2 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD03_hard_1.png', 'answer'=> 1 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD02_med_1.png', 'answer'=> 1 , 'principle_id'=> 4 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD08_med_4.png', 'answer'=> 4 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD04_easy_1.png', 'answer'=> 1 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD07_hard_2.png', 'answer'=> 2 , 'principle_id'=> 3 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD06_hard_4.png', 'answer'=> 4 , 'principle_id'=> 4 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD10_med_3.png', 'answer'=> 3 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD18_easy_4.png', 'answer'=> 4 , 'principle_id'=> 7 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD25_hard_2.png', 'answer'=> 2 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD24_hard_3.png', 'answer'=> 3 , 'principle_id'=> 5 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD23_med_1.png', 'answer'=> 1 , 'principle_id'=> 7 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD22_hard_2.png', 'answer'=> 2 , 'principle_id'=> 3 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD21_hard_2.png', 'answer'=> 2 , 'principle_id'=> 4 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD19_hard_2.png', 'answer'=> 2 , 'principle_id'=> 6 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD20_hard_4.png', 'answer'=> 4 , 'principle_id'=> 2 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD26_easy_3.png', 'answer'=> 3 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD25_med_1.png', 'answer'=> 1 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD24_med_3.png', 'answer'=> 3 , 'principle_id'=> 11 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD23_hard_1.png', 'answer'=> 1 , 'principle_id'=> 11 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq22_med_1.png', 'answer'=> 1 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq12_med_4.png', 'answer'=> 4 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq11_med_2.png', 'answer'=> 2 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq14_med_3.png', 'answer'=> 3 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq16_easy_3.png', 'answer'=> 3 , 'principle_id'=> 13 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq20_med_1.png', 'answer'=> 1 , 'principle_id'=> 18 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq01_med_3.png', 'answer'=> 3 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq04_hard_2.png', 'answer'=> 2 , 'principle_id'=> 14 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq05_hard_1.png', 'answer'=> 1 , 'principle_id'=> 13 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq08_hard_4.png', 'answer'=> 4 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq07_hard_3.png', 'answer'=> 3 , 'principle_id'=> 18 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq10_med_2.png', 'answer'=> 2 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq09_hard_2.png', 'answer'=> 2 , 'principle_id'=> 14 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq23_med_3.png', 'answer'=> 3 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq24_easy_3.png', 'answer'=> 3 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq35_med_1.png', 'answer'=> 1 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq36_hard_1.png', 'answer'=> 1 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq38_hard_2.png', 'answer'=> 2 , 'principle_id'=> 20 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq42_hard_4.png', 'answer'=> 4 , 'principle_id'=> 20 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq34_med_3.png', 'answer'=> 3 , 'principle_id'=> 21 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq28_easy_3.png', 'answer'=> 3 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq26_easy_3.png', 'answer'=> 3 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/Equation/eq27_easy_3.png', 'answer'=> 3 , 'principle_id'=> 21 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq36_med_1.png', 'answer'=> 1 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq33_med_1.png', 'answer'=> 1 , 'principle_id'=> 19 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq43_hard_2.png', 'answer'=> 2 , 'principle_id'=> 21 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq41_hard_2.png', 'answer'=> 2 , 'principle_id'=> 13 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq37_hard_1.png', 'answer'=> 1 , 'principle_id'=> 15 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD09_med_3.png', 'answer'=> 3 , 'principle_id'=> 5 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD34_med_4.png', 'answer'=> 4 , 'principle_id'=> 7 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD33_med_4.png', 'answer'=> 4 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD11_med_3.png', 'answer'=> 3 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD13_easy_2.png', 'answer'=> 2 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD14_easy_3.png', 'answer'=> 3 , 'principle_id'=> 7 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD15_easy_3.png', 'answer'=> 3 , 'principle_id'=> 7 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD16_easy_1.png', 'answer'=> 1 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD17_easy_2.png', 'answer'=> 2 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD26_hard_2.png', 'answer'=> 2 , 'principle_id'=> 6 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD29_hard_2.png', 'answer'=> 2 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD28_med_1.png', 'answer'=> 1 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD29_easy_4.png', 'answer'=> 4 , 'principle_id'=> 12 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD28_easy_2.png', 'answer'=> 2 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD28_hard_2.png', 'answer'=> 2 , 'principle_id'=> 4 ),
            array('chapter_id'=> 2, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/GCD/GCD27_hard_3.png', 'answer'=> 3 , 'principle_id'=> 2 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD27_easy_3.png', 'answer'=> 3 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD31_easy_1.png', 'answer'=> 1 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD31_med_2.png', 'answer'=> 2 , 'principle_id'=> 5 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD32_med_3.png', 'answer'=> 3 , 'principle_id'=> 11 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD32_easy_4.png', 'answer'=> 4 , 'principle_id'=> 9 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD33_easy_2.png', 'answer'=> 2 , 'principle_id'=> 12 ),
            array('chapter_id'=> 2, 'level_id'=> 1, 'local_pic'=>'img/exam/Math/GCD/GCD30_easy_2.png', 'answer'=> 2 , 'principle_id'=> 12 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD30_med_4.png', 'answer'=> 4 , 'principle_id'=> 10 ),
            array('chapter_id'=> 2, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/GCD/GCD29_med_2.png', 'answer'=> 2 , 'principle_id'=> 12 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq06_hard_4.png', 'answer'=> 4 , 'principle_id'=> 1 ),
            array('chapter_id'=> 1, 'level_id'=> 3, 'local_pic'=>'img/exam/Math/Equation/eq46_hard_2.png', 'answer'=> 2 , 'principle_id'=> 22 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq37_med_2.png', 'answer'=> 2 , 'principle_id'=> 13 ),
            array('chapter_id'=> 1, 'level_id'=> 2, 'local_pic'=>'img/exam/Math/Equation/eq36_med_4.png', 'answer'=> 4 , 'principle_id'=> 19 ),

        ));
    }
}
