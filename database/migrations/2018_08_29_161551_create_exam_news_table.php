<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_news', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('chapter_id');
            $table->Integer('level_id');
            $table->string('question');
            $table->string('choice_a');
            $table->string('choice_b');
            $table->string('choice_c');
            $table->string('choice_d');
            $table->string('local_pic');
            $table->smallInteger('answer'); //1,2,3,4
            $table->Integer('principle_id');
            // $table->foreign('level_id')->references('id')->on('levels');
            // $table->foreign('principle_id')->references('id')->on('printciples');
            // $table->foreign('chapter_id')->references('id')->on('chapters');
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
        Schema::dropIfExists('exam_news');
    }
}
