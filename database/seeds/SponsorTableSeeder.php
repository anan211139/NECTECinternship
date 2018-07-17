<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sponsors')->delete();
      DB::table('sponsors')->insert(array(
        array('name' =>	'iammmickky', 'local_pic'=>	'img/sponsor/pmic_p.png', 'phone' =>	'099'),
        array('name' =>	'ice', 'local_pic'=>	'img/sponsor/ice_p.png', 'phone' =>	'086'),
        array('name' =>	'anan', 'local_pic'=>	'gooo!', 'phone' =>	'90'),
        array('name' =>	'wari', 'local_pic'=>	'img/sponsor/wari_p.png', 'phone' =>	'4400'),
      ));
    }
}
