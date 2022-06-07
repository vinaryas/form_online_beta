<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class register extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'name', 'username', 'region_id',
         'dapartemen_id','email', ];

    protected $hidden = [
        'password', 'remember_token',];
}
