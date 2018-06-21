<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('groupnoID');
            $table->Integer('STcodeID');
            $table->smallInteger('levelID'); //1 easy, 2 med, 3 hard
            $table->Integer('max'); // the number of tests for this lvl
            $table->Integer('true'); //the number of corrected tests
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
        Schema::dropIfExists('results');
    }
}
