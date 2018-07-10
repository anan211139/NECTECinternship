<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //php artisan migrate:reset
        //php artisan migrate:fresh
        //php artisan db:seed

        Eloquent::unguard();

        //call uses table seeder class
        $this->call([
            ExamTableSeeder::class,
            PrincipleTableSeeder::class
        ]);
        //this message shown in your terminal after running db:seed command
        $this->command->info("Exam & Principle table seeded :)");

        //other fixed table
        DB::table('chapters')->insert([['name' => 'Equation'],['name' => 'GCD']]);
        DB::table('subjects')->insert([['name' => 'Mathematics'],['name' => 'English']]);
        DB::table('levels')->insert([['name' => 'easy'],['name' => 'medium'],['name' => 'hard']]);
        DB::table('types')->insert([['name' => 'code'],['name' => 'delivery']]);
        DB::table('groups')->insert([
            ['line_code' => "U9a9b0cd702b6581861d1c93957eeb9c4",'subject_id'=>1,'chapter_id'=>1,'status'=>false],
            ['line_code' => "U64f1e2fafcec762ce15e48cc567d696b",'subject_id'=>1,'chapter_id'=>1,'status'=>false],
            ['line_code' => "U038940166356c6b9fb0dcf051aded27f",'subject_id'=>1,'chapter_id'=>1,'status'=>false]
        ]);
    }
}
