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
            Exam_NewTableSeeder::class,
            PrincipleTableSeeder::class,
            PrizesTableSeeder::class,
            SponsorTableSeeder::class,
            GroupsTableSeeder::class,
            ResultTableSeeder::class,
            StudentsTableSeeder::class,
            StudentParentsTableSeeder::class
        ]);
        //this message shown in your terminal after running db:seed command
        $this->command->info("Exam & Principle table seeded :)");

        //other fixed table
        DB::table('chapters')->insert([
          ['subject_id' => 1, 'name' => 'MathChapter1'],
          ['subject_id' => 1, 'name' => 'MathChapter2'],
          ['subject_id' => 2, 'name' => 'EnglishChapter1'],
          ['subject_id' => 2, 'name' => 'EnglishChapter2']
        ]);
        DB::table('subjects')->insert([['name' => 'Math'],['name' => 'English']]);
        DB::table('levels')->insert([['name' => 'easy'],['name' => 'medium'],['name' => 'hard']]);
        DB::table('types')->insert([['name' => 'code'],['name' => 'delivery']]);
        DB::table('codes')->insert([['prize_id' => 1,'code' => 'hitherethisisacat'],['prize_id' => 1,'code' => 'a8e3f3f'],
                                    ['prize_id' => 1,'code' => 'asdfghj'],['prize_id' => 2,'code' => 'khunWARI'],
                                    ['prize_id' => 2,'code' => 'khunCHAMILK'],['prize_id' => 3,'code' => 'khunJIAE'],
                                    ['prize_id' => 3,'code' => 'khunICE'],['prize_id' => 4,'code' => 'khunANAN'],
                                    ['prize_id' => 4,'code' => 'khunPEI'],['prize_id' => 5,'code' => 'khunOAT'],
                                    ['prize_id' => 5,'code' => 'khunTON']]);
    }
}
