<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            array('local_pic'=>'img/princ/Math/eq.png'),
            array('local_pic'=>'img/princ/Math/clock.png'),
            array('local_pic'=>'img/princ/Math/gcd_frac.png'),
            array('local_pic'=>'img/princ/Math/gcd_fruits.png'),
            array('local_pic'=>'img/princ/Math/gcd_no_frac.png'),
            array('local_pic'=>'img/princ/Math/gcd_rope.png'),
            array('local_pic'=>'img/princ/Math/lcm_frac.png'),
            array('local_pic'=>'img/princ/Math/lcm_org.png'),
            array('local_pic'=>'img/princ/Math/lcm.png'),
            array('local_pic'=>'img/princ/Math/gcd.png'),
            array('local_pic'=>'img/princ/Math/gcd_lcm.png'),
            array('local_pic'=>'img/princ/Math/factor.png'),
            array('local_pic'=>'img/princ/Math/age_much.png'),
            array('local_pic'=>'img/princ/Math/age.png'),
            array('local_pic'=>'img/princ/Math/banknote.png'),
            array('local_pic'=>'img/princ/Math/book.png'),
            array('local_pic'=>'img/princ/Math/coin.png'),
            array('local_pic'=>'img/princ/Math/devide_money.png'),
            array('local_pic'=>'img/princ/Math/easy.png'),
            array('local_pic'=>'img/princ/Math/hard.png'),
            array('local_pic'=>'img/princ/Math/med_borrow.png'),
            array('local_pic'=>'img/princ/Math/prince_46.png'),
         ));
    }
}
