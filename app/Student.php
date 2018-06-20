<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['STcodeID', 'STName', 'STLocalPic', 'point', 'birthofdate', 'STEmail', 'phone', 'address', 'schoolID'];
}
