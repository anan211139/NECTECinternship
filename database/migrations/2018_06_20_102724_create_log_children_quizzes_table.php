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
            $table->dateTimeTz('time')->nullable(); //update
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
