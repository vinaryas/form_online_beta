<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class form extends Model
{
    protected $table = 'form';
    protected $fillable = ([
        'username',
        'user_id',
        'region_id',
        'store_id',
        'role_id',
        'dapartemen_id',
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

    public function dapartemen()
    {
        return $this->hasOne(dapartemen::class, 'id', 'dapartemen_id');
    }

    public function user()
    {
        return $this->hasOne(user::class,'id', 'user_id');
    }

    public function aplikasi()
    {
        return $this->hasMany(aplikasi::class,'id', 'aplikasi_id');
    }

    public function formAplikasi()
    {
        return $this->belongsTo(formAplikasi::class, 'id', 'form_id');
    }

}
