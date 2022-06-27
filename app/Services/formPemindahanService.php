<?php

namespace App\Services;

use App\Models\formPemindahan;
use Illuminate\Support\Facades\DB;

class formPemindahanService
{
   private $formPemindahan;

   public function __construct(formPemindahan $formPemindahan)
    {
        $this->formPemindahan = $formPemindahan;
    }

   public function all()
	{
		return $this->formPemindahan->query();
	}

    public function store($data){
        return $this->formPemindahan->create($data);
    }

    public function getDetail(){
        $data = DB::table('form_pemindahan')
        ->join('users', 'form_pemindahan.created_by', '=', 'users.id')
        ->join('regions', 'form_pemindahan.region_id', '=', 'regions.id')
        ->select(
            'form_pemindahan.id as form_pemindahan_id',
            'form_pemindahan.created_by',
            'form_pemindahan.created_at',
            'form_pemindahan.from_store as from_store',
            'form_pemindahan.to_store as to_store',
            'users.id as user_id',
            'users.username as nik',
            'users.name as name',
            'regions.name as nama_region'
        );

        return $data;
    }

    public function getByUserId($userId){
        return $this->getDetail()->where('form_pemindahan.created_by', $userId);
    }

}
