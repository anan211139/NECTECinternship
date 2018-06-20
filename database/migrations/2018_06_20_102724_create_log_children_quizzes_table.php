<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogChildrenQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logChildrenQuizzes', function (Blueprint $table) { //create when random exam
            $table->increments('id');
            $table->Integer('groupnoID');
            $table->Integer('numbertest');
            $table->Integer('ExamID'); // present exam
            $table->Integer('STAnswer'); //real ans
            $table->Integer('answerStatus'); //true-false
            $table->dateTimeTz('time'); //update
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logChildrenQuizzes');
    }
}
