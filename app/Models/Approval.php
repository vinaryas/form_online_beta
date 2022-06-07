<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\User;

class Approval extends Model
{
    protected $table = 'history_approval';
    protected $guarded = [];
    protected $fillable = ['form_aplikasi_id', 'user_id','username','name' ,'role_id', 'region_id', 'status'];

    public function user()
    {
    	return $this->hasOne(user::class, 'id', 'user_id');
    }

    public function form()
    {
    	return $this->hasOne(form::class, 'id', 'form_id');
    }

    public function role()
    {
    	return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function formAplikasi()
    {
        return $this->hasOne(formAplikasi::class,'id', 'form_aplikasi_id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y');
    }
}
