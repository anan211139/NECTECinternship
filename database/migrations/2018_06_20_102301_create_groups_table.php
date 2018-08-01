<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_code');
            $table->Integer('chapter_id');
            $table->boolean('status')->default(false); //boolean true if the student finish all their exam
            $table->Integer('score')->nullable();
            // $table->foreign('line_code')->references('line_code')->on('students');
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
        Schema::dropIfExists('groups');
    }
}
