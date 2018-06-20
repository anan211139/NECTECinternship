<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['levelID', 'subjectID', 'chapterID', 'ELocalPic', 'answerStatus', 'PrincipleID'];
}
