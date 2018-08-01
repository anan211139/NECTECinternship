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
            PrincipleTableSeeder::class,
            PrizesTableSeeder::class,
            SponsorTableSeeder::class,
            GroupsTableSeeder::class,
            ResultTableSeeder::class,
            StudentTableSeeder::class
        ]);
        //this message shown in your terminal after running db:seed command
        $this->command->info("Exam & Principle table seeded :)");

        //other fixed table
        DB::table('chapters')->insert([['subject_id' => 1, 'name' => 'Equation'],['subject_id' => 1, 'name' => 'GCD']]);
        DB::table('subjects')->insert([['name' => 'Mathematics'],['name' => 'English']]);
        DB::table('levels')->insert([['name' => 'easy'],['name' => 'medium'],['name' => 'hard']]);
        DB::table('types')->insert([['name' => 'code'],['name' => 'delivery']]);
    }
}
