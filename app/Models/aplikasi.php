<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class aplikasi extends Model
{
    protected $table ='aplikasi';
    protected $guarded = [];

    public function form_head()
    {
        return $this->hasOne(form_head::class, 'id', 'aplikasi_id');
    }

    public function formPembuatan()
    {
        return $this->belongsTo(formPembuatan::class, 'id', 'aplikasi_id');
    }
}
