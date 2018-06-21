<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = ['PRname', 'UNPR', 'PWPR', 'PREmail'];
}
