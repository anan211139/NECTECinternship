<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $fillable = ['sponsor_id', 'name', 'local_pic', 'value', 'point', 'limit', 'type_id'];
}
