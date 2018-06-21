<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('STcodeID');
            $table->string('STName');
            $table->string('STLocalPic')->nullable(); //path to profile picture parents uploaded.
            $table->Integer('point');
            $table->date('birthofdate')->nullable();
            $table->string('STEmail')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->Integer('schoolID')->nullable();
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
        Schema::dropIfExists('students');
    }
}
