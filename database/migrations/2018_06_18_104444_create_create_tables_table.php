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
            $table->autoIncrement('teacherID');
            $table->string('TCname');
            $table->string('UNTC');
            $table->string('PWTC');
            $table->string('TCEmail');
            $table->timestampsTz();
        });
        Schema::create('parent', function (Blueprint $table) {
            $table->autoIncrement('parentID');
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
            $table->timestampsTz();
        });
        Schema::create('Exam', function (Blueprint $table) {
            $table->autoIncrement('ExamID');
            $table->Integer('levelID');
            $table->string('subjectID');
            $table->Integer('chapterID');
            $table->string('ELocalPic');
            $table->smallInteger('answerStatus');
            $table->Integer('PrincipleID');
            $table->timestampsTz();
        });
        Schema::create('subject', function (Blueprint $table) {
            $table->autoIncrement('subjectID');
            $table->string('Namesubject');
        });
        Schema::create('chapter', function (Blueprint $table) {
            $table->autoIncrement('chapterID');
            $table->string('Namechapter');
        });
        Schema::create('level', function (Blueprint $table) {
            $table->autoIncrement('levelID');
            $table->string('Namelevel');
        });
        Schema::create('printciple', function (Blueprint $table) {
            $table->autoIncrement('printcipleID');
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
            $table->autoIncrement('groupRanID');
            $table->Integer('groupnoID');
            $table->string('listExamID');
            $table->string('listLevelID');
            $table->timestampsTz();
        });
        Schema::create('group', function (Blueprint $table) {
            $table->autoIncrement('groupnoID');
            $table->Integer('STcodeID');
            $table->Integer('subjectID');
            $table->Integer('chepterID');
            $table->Integer('momentStatus');
            $table->dateTimeTz('3day');
            $table->dateTimeTz('7day');
            $table->timestampsTz();
        });Schema::create('log_children_quiz', function (Blueprint $table) {
            $table->autoIncrement('id');
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
