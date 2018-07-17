<?php

use Illuminate\Database\Seeder;

class PrizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('exams')->delete();
      //insert some dummy records
      DB::table('exams')->insert(array(
      array('sponsor_id'=>	1	, 'name' => 'ดินวิทยาศาสตร์'	, 'local_pic' =>'img/sponsor/pmic_p.png'	,'value' =>	50	,'point' =>	100	,'type_id' =>	1),
      array('sponsor_id'=>	2	, 'name' => 'คอร์สเรียน cmd'	, 'local_pic' =>'img/sponsor/ice_p.png'	,'value' =>	200	,'point' =>	150	,'type_id' =>	1),
      array('sponsor_id'=>	4	, 'name' => 'คอร์สปลูกต้นไม้'	, 'local_pic' =>'img/sponsor/wari_p.png'	,'value' =>	150	,'point' =>	150	,'type_id' =>	1),
    ));
    }
}
