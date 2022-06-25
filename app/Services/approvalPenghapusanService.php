<?php

namespace App\Services;

use App\Models\approvalPenghapusan;
use App\Services\Support\MappingApprovalPenghapusanService;
use Illuminate\Support\Facades\DB;

class approvalPenghapusanService
{
private $approvalPenghapusan;

    public function __construct(approvalPenghapusan $approvalPenghapusan)
    {
        $this->approvalPenghapusan = $approvalPenghapusan;
    }

    public function all()
    {
        return $this->approvalPenghapusan->query()->with('formPembuatan', 'form', 'user', 'role');
    }

    public function store($data)
    {
        return $this->approvalPenghapusan->create($data);
    }

    public function getNextApp($aplikasi, $roleId, $regionId)
    {
        $thisPosition = MappingApprovalPenghapusanService::getByTypeRoleId($aplikasi, $roleId, $regionId)->first()->position;

        $nextPosition = MappingApprovalPenghapusanService::getByPosition($thisPosition + 1, $regionId, $aplikasi)->first();

        return ($nextPosition != null) ? $nextPosition->role_id : 0;
    }
}
