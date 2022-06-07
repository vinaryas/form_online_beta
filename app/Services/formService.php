<?php

namespace App\Services;

use App\Helper\MyHelper;
use App\Models\form;
use App\Services\Support\MappingApprovalService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class formService
{
   private $form;

   public function __construct(form $form)
    {
        $this->form = $form;
    }

   public function all()
	{
		return $this->form->query()->with('user', 'formAplikasi', 'aplikasi');
	}

    public function store($data)
    {
        return $this->form->create($data);
    }

    public function getNextApp($aplikasi, $roleId, $regionId)
    {
        $thisPosition = MappingApprovalService::getByTypeRoleId($aplikasi, $roleId, $regionId)->first()->position;

        $nextPosition = MappingApprovalService::getByPosition($thisPosition + 1, $regionId, $aplikasi)->first();

        return ($nextPosition != null) ? $nextPosition->role_id : 0;
    }

    public function countForm($userId){
        return $this->form->where('user_id', $userId);
    }

    public function countAdmin(){
        return $this->form->query();
    }

}


