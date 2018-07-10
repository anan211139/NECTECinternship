<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['subject_id', 'chapter_id', 'level_id', 'local_pic', 'answer', 'principle_id'];
}
