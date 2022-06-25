<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\User;

class approvalPembuatan extends Model
{
    protected $table = 'approval_pembuatan';
    protected $guarded = [];
    protected $fillable = ['form_pembuatan_id', 'approved_by','approver_nik','approver_name' ,'approver_role_id', 'approver_region_id', 'status'];

    public function user()
    {
    	return $this->hasOne(user::class, 'id', 'approved_by');
    }

    public function form()
    {
    	return $this->hasOne(form::class, 'id', 'form_id');
    }

    public function role()
    {
    	return $this->hasOne(Role::class, 'id', 'approver_role_id');
    }

    public function formPembuatan()
    {
        return $this->hasOne(formPembuatan::class,'id', 'form_pembuatan_id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y');
    }
}
