<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formPembuatan extends Model
{
    protected $table ='form_pembuatan';
    protected $fillable = [
        'aplikasi_id',
        'form_id',
        'pass',
        'store',
        'role_last_app',
        'role_next_app',
        'status',
        'created_by',
        'type',
        'id_vega'
    ];

    public function form_head(){
        return $this->hasOne(form_head::class, 'id', 'form_id');
    }

    public function aplikasi(){
        return $this->hasMany(aplikasi::class, 'id', 'aplikasi_id' );
    }

    public function store(){
        return $this->hasMany(store::class, 'id', 'store');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'form_pembuatan_id', 'id');
    }

    public function lastApproval()
    {
        return $this->approval()->latest();
    }

}

