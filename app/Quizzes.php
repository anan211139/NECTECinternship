<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quizzes extends Model
{
    public $timestamps = false;
    protected $fillable = ['question', 'level', 'subject', 'topic', 'answer'];
}
