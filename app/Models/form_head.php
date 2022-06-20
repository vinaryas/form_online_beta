<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class form_head extends Model
{
    protected $table = 'form_head';
    protected $fillable = ([
        'username',
        'user_id',
        'region_id',
        'store_id',
        'role_id',
        'store_id',
        'pass',
        'aplikasi_id',
    ]);

    public function store()
    {
        return $this->hasOne(store::class, 'id', 'store_id');
    }

    public function region()
    {
        return $this->hasOne(region::class, 'id', 'region_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function user()
    {
        return $this->hasOne(user::class,'id', 'user_id');
    }

    public function aplikasi()
    {
        return $this->hasMany(aplikasi::class,'id', 'aplikasi_id');
    }

    public function formPembuatan()
    {
        return $this->belongsTo(formPembuatan::class, 'id', 'form_id');
    }

}
