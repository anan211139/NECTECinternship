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
        Schema::create('teacher', function (Blueprint $table) {
            $table->increments('teacherID');
            $table->string('TCname');
            $table->string('UNTC');
            $table->string('PWTC');
            $table->string('TCEmail');
            $table->Integer('schoolID');
            $table->timestampsTz();
        });
        Schema::create('parent', function (Blueprint $table) {
            $table->increments('parentID');
            $table->string('PRname');
            $table->string('UNPR');
            $table->string('PWPR');
            $table->string('PREmail');
            $table->timestampsTz();
        });
        Schema::create('student', function (Blueprint $table) {
            $table->string('STcodeID');
            $table->string('STName');
            $table->string('STLocalPic');
            $table->Integer('point');
            $table->date('birthofdate');
            $table->string('STEmail');
            $table->string('phone');
            $table->string('address');
            $table->Integer('schoolID');
            $table->timestampsTz();
        });
        Schema::create('Exam', function (Blueprint $table) {
            $table->increments('ExamID');
            $table->Integer('levelID');
            $table->Integer('subjectID');
            $table->Integer('chapterID');
            $table->string('ELocalPic');
            $table->smallInteger('answerStatus');
            $table->Integer('PrincipleID');
            $table->timestampsTz();
        });
        Schema::create('results', function (Blueprint $table) {
            $table->Integer('groupnoID');
            $table->Integer('STcodeID');
            $table->smallInteger('levelID');
            $table->Integer('max');
            $table->Integer('ture');
        });
        Schema::create('school', function (Blueprint $table) {
            $table->increments('schoolID');
            $table->string('schoolname');
            $table->string('address');
            $table->string('phone');
        });
        Schema::create('subject', function (Blueprint $table) {
            $table->increments('subjectID');
            $table->string('Namesubject');
        });
        Schema::create('chapter', function (Blueprint $table) {
            $table->increments('chapterID');
            $table->string('Namechapter');
        });
        Schema::create('level', function (Blueprint $table) {
            $table->increments('levelID');
            $table->string('Namelevel');
        });
        Schema::create('printciple', function (Blueprint $table) {
            $table->increments('printcipleID');
            $table->string('PLocalPic');
        });
        Schema::create('studentparent', function (Blueprint $table) {
            $table->Integer('STcodeID');
            $table->Integer('parentID');
            $table->timestampsTz();
        });
        Schema::create('STandTC', function (Blueprint $table) {
            $table->Integer('STcodeID');
            $table->Integer('teacherID');
            $table->timestampsTz();
        });
        Schema::create('groupRandom', function (Blueprint $table) {
            $table->increments('groupRanID');
            $table->Integer('groupnoID');
            $table->string('listExamID');
            $table->string('listLevelID');
            $table->timestampsTz();
        });
        Schema::create('group', function (Blueprint $table) {
            $table->increments('groupnoID');
            $table->Integer('STcodeID');
            $table->Integer('subjectID');
            $table->Integer('chepterID');
            $table->Integer('momentStatus');
            $table->dateTimeTz('3day');
            $table->dateTimeTz('7day');
            $table->timestampsTz();
        });Schema::create('log_children_quiz', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('groupnoID');
            $table->Integer('numbertest');
            $table->Integer('ExamID');
            $table->Integer('STAnswer');
            $table->Integer('answerStatus');
            $table->dateTimeTz('time');
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
        Schema::dropIfExists('create_tables');
    }
}
