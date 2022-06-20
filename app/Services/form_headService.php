<?php

namespace App\Services;

use App\Models\form_head;
use App\Services\Support\MappingApprovalService;

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

}


