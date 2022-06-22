<?php

namespace App\Services;

use App\Models\form_head;
use App\Services\Support\MappingApprovalService;
use Illuminate\Support\Facades\DB;

class form_headService
{
   private $form_head;

   public function __construct(form_head $form_head)
    {
        $this->form_head = $form_head;
    }

   public function all()
	{
		return $this->form_head->query()->with('user', 'formPembuatan', 'aplikasi');
	}

    public function store($data)
    {
        return $this->form_head->create($data);
    }

    public function getNextApp($aplikasi, $roleId, $regionId)
    {
        $thisPosition = MappingApprovalService::getByTypeRoleId($aplikasi, $roleId, $regionId)->first()->position;

        $nextPosition = MappingApprovalService::getByPosition($thisPosition + 1, $regionId, $aplikasi)->first();

        return ($nextPosition != null) ? $nextPosition->role_id : 0;
    }

    public function countForm($userId){
        return $this->form_head->where('user_id', $userId);
    }

    public function countAdmin(){
        return $this->form_head->query();
    }

    public function getDetail(){
        $data = DB::table('form_head')
        ->join('form_pembuatan', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.user_id', '=', 'users.id')
        ->leftjoin('stores', 'form_head.store_id', '=', 'stores.id')
        ->join('regions', 'form_head.region_id', '=', 'regions.id')
        ->select(
            'form_head.id as form_id',
            'form_head.user_id as user_id',
            'form_head.nik as nik',
            'form_pembuatan.id as form_pembuatan_id',
            'form_head.created_at',
            'form_head.region_id',
            'form_head.store_id',
            'stores.name as nama_store',
            'regions.name as nama_region'
        );

        return $data;
    }

}


