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
        Schema::create('logChildrenQuizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('groupnoID');
            $table->Integer('numbertest');
            $table->Integer('ExamID');
            $table->Integer('STAnswer');
            $table->Integer('answerStatus');
            $table->dateTimeTz('time');
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
