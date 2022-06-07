<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
    protected $guarded = [];

    public function region()
    {
        return $this->hasOne(region::class, 'id', 'region_id');
    }

    public function userStore()
    {
        return $this->hasOne(UserStore::class, 'id', 'store_id');
    }

}
