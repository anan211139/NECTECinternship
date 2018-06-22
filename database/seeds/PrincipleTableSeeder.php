<?php

use Illuminate\Database\Seeder;

class PrincipleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete printciples table records
        DB::table('printciples')->delete();
        //insert some dummy records
        DB::table('printciples')->insert(array(
            array('local_pic'=>'img/princ/Math/princ.png'),
         ));
    }
}
