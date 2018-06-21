<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['line_code', 'group_id', 'level_id', 'total_level', 'total_level_true'];
}
