<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class aplikasi extends Model
{
    protected $table ='aplikasi';
    protected $guarded = [];

    public function form()
    {
        return $this->hasOne(form::class, 'id', 'aplikasi_id');
    }

    public function formAplikasi()
    {
        return $this->belongsTo(formAplikasi::class, 'id', 'aplikasi_id');
    }
}
