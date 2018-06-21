<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogChildrenQuiz extends Model
{
    protected $fillable = ['group_id', 'exam_id', 'answer', 'is_correct', 'time'];
}
