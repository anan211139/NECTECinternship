<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['groupnoID', 'STcodeID', 'levelID', 'max', 'true'];
}
