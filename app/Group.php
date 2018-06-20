<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['STcodeID', 'subjectID', 'chepterID', 'momentStatus'];
}
