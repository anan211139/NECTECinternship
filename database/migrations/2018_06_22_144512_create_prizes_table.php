<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('sponsor_id');
            $table->string('name');
            $table->string('local_pic');
            $table->Integer('value');
            $table->Integer('point'); //least point to exchange
            $table->dateTimeTz('limit')->nullable();
            $table->Integer('type_id');
            // $table->foreign('sponsor_id')->references('id')->on('sponsors');
            // $table->foreign('type_id')->references('id')->on('types');
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
        Schema::dropIfExists('prizes');
    }
}
