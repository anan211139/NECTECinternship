<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->timestamps();
        });
        Schema::create('child', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_id');
            $table->string('name');
            $table->Integer('point');
            $table->timestamps();
        });
        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id');
            $table->string('detail');
            $table->Integer('level');
            $table->string('subject');
            $table->Integer('lesson');
            $table->string('local_pic');
            $table->smallInteger('answer');
            $table->timestamps();
        });
        // Schema::create('Choice', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('detail');
        //     $table->string('order');
        //     $table->timestamps();
        // });
        Schema::create('tescher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->timestamps();
        });
        Schema::create('subject', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->timestamps();
        });
        Schema::create('lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lesson');
            $table->timestamps();
        });
        Schema::create('ParentAndChild', function (Blueprint $table) {
            $table->Integer('ID_Parent');
            $table->Integer('line_id');
            $table->timestamps();
        });
        Schema::create('TeacherAndChild', function (Blueprint $table) {
            $table->Integer('ID_teacher');
            $table->Integer('line_id');
            $table->timestamps();
        });
        Schema::create('TempForRandom', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_part');
            $table->string('list_id_q');
            $table->string('list_level');
            $table->timestamps();
        });
        Schema::create('part', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_child');
            $table->Integer('id_subject');
            $table->Integer('id_lesson');
            $table->timestamps();
        });Schema::create('log_children_quiz', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_part');
            $table->Integer('number');
            $table->Integer('id_quiz');
            $table->Integer('id_level');
            $table->Integer('tf');
            $table->datetime('reply');
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
        Schema::dropIfExists('create_tables');
    }
}
