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
            $table->Integer('group_id');
            $table->Integer('exam_id'); // present exam
            $table->smallInteger('answer')->nullable(); //real ans
            $table->boolean('is_correct')->nullable(); //true-false
            $table->boolean('second_chance')->default(false);
            $table->boolean('is_correct_second')->nullable();
            $table->dateTimeTz('time')->nullable(); //update
            // $table->foreign('group_id')->references('id')->on('groups');
            // $table->foreign('exam_id')->references('id')->on('exams');
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
