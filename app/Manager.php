<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = ['name', 'username', 'password', 'email'];
    protected $hidden = ['password', 'remember_token'];
}
