<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('chapter_id');
            $table->Integer('level_id');
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
        Schema::dropIfExists('exams');
    }
}
