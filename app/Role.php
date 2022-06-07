<?php

namespace App;

use Laratrust\Models\LaratrustRole;
use DB;

class Role extends LaratrustRole
{
    protected $table = 'roles';
    protected $guarded = [];

}
