<?php

namespace App\ModelsConnection;

use Illuminate\Database\Eloquent\Model;

class first_time_sync extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'first_time_sync';
    protected $fillable = (['store', 'status']);

    const UPDATED_AT = null;
    const CREATED_AT = null;
}
