<?php

namespace App\Services;

use App\Models\formPenghapusan;
use App\Models\logFormPenghapusan;
use Illuminate\Support\Facades\DB;

class logFormPenghapusanService
{
   private $logFormPenghapusan;

   public function __construct(logFormPenghapusan $logFormPenghapusan)
    {
        $this->logFormPenghapusan = $logFormPenghapusan;
    }

   public function all()
	{
		return $this->logFormPenghapusan->query()->with('form_head');
	}

    public function store($data){
        return $this->logFormPenghapusan->create($data);
    }

    public function getDetail(){
        $data = DB::table('log_form_penghapusan')
        ->join('users', 'log_form_penghapusan.created_by', '=', 'users.id')
        ->leftJoin('stores', 'log_form_penghapusan.store_id', '=', 'stores.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->select(
            'log_form_penghapusan.id as form_penghapusan_id',
            'log_form_penghapusan.created_by',
            'log_form_penghapusan.nik',
            'log_form_penghapusan.created_at',
            'regions.id as region_id',
            'regions.name as nama_region',
            'stores.id as store_id',
            'stores.name as nama_store',
            'users.name as user_name',
        );

        return $data;
    }

    public function getDetaiilFormPenghapusan(){
        $data = DB::table('log_form_penghapusan')
        ->join('form_penghapusan', 'log_form_penghapusan.id', '=', 'form_penghapusan.log_form_penghapusan_id')
        ->join('users', 'log_form_penghapusan.created_by', '=', 'users.id')
        ->leftJoin('stores', 'log_form_penghapusan.store_id', '=', 'stores.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->select(
            'form_penghapusan.id as form_penghapusan_id',
            'form_penghapusan.role_next_app',
            'form_penghapusan.created_at',
            'form_penghapusan.deleted_user_id',
            'form_penghapusan.deleted_nik as deleted_nik',
            'log_form_penghapusan.id as log_form_penghapusan_id',
            'log_form_penghapusan.created_by as created_by',
            'log_form_penghapusan.nik as nik',
            'regions.id as region_id',
            'regions.name as nama_region',
            'stores.id as store_id',
            'stores.name as nama_store',
            'users.name',
            'stores.name as nama_store',
        );

        return $data;
    }

    public function getById($formPenghapusan){
        return $this->getDetaiilFormPenghapusan()
        ->where('form_penghapusan.id', $formPenghapusan);
    }

}
