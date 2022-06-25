<?php

namespace App\Services;

use App\Models\formPenghapusan;
use Illuminate\Support\Facades\DB;

class formPenghapusanService
{
   private $formPenghapusan;

   public function __construct(formPenghapusan $formPenghapusan)
    {
        $this->formPenghapusan = $formPenghapusan;
    }

   public function all()
	{
		return $this->formPenghapusan->query()->with('form_head');
	}

    public function store($data){
        return $this->formPenghapusan->create($data);
    }

    public function getDetaiilFormPenghapusan(){
        $data = DB::table('form_penghapusan')
        ->join('users', 'form_penghapusan.deleted_user_id', '=', 'users.id')
        ->leftJoin('stores', 'form_penghapusan.store', '=', 'stores.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->select(
            'form_penghapusan.id as form_penghapusan_id',
            'form_penghapusan.role_next_app',
            'form_penghapusan.created_at',
            'form_penghapusan.deleted_user_id',
            'form_penghapusan.deleted_nik as deleted_nik',
            'regions.id as region_id',
            'regions.name as nama_region',
            'stores.id as store_id',
            'stores.name as nama_store',
            'users.name',
            'stores.name as nama_store',
        );

        return $data;
    }


}
