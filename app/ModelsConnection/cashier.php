<?php

namespace App\ModelsConnection;

use Illuminate\Database\Eloquent\Model;

class cashier extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'cashier';
    protected $fillable = (['cashnum', 'nama', 'roles', 'store', 'password', 'status', 'acc']);

    const UPDATED_AT = null;
    const CREATED_AT = null;
}
