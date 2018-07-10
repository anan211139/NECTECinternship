<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['line_code', 'subject_id', 'chapter_id', 'status'];
}
