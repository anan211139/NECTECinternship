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
            $table->Integer('numbertest'); // order of the present exam (1 to 20)
            $table->Integer('ExamID'); // present exam
            $table->Integer('STAnswer'); //student's ans
            $table->Integer('answerStatus')->nullable(); //0:wrong answer, 1:correct answer
            $table->dateTimeTz('time'); //update time
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
