<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogChildrenQuiz extends Model
{
    protected $fillable = ['groupnoID', 'numbertest', 'ExamID', 'STAnswer', 'answerStatus', 'time'];
}
