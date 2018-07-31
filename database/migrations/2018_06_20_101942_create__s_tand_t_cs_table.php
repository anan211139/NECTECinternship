<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSTandTCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('STandTCs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_code');
            $table->Integer('teacher_id');
            // $table->foreign('line_code')->references('line_code')->on('students');
            // $table->foreign('teacher_id')->references('id')->on('teachers');
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
        Schema::dropIfExists('STandTCs');
    }
}
