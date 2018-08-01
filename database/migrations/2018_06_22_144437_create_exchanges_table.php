<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_code');
            $table->smallInteger('send')->default(1); //1 in progress of delivery, 2 delivered, 3 delivery is not success
            $table->Integer('code_id')->nullable();
            $table->dateTimeTz('time');
            // $table->foreign('line_code')->references('line_code')->on('students');
            // $table->foreign('code_id')->references('id')->on('codes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
