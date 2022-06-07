<?php

namespace App\Services;

use App\Models\MappingApproval;

class MappingApprovalService
{
    private $mappingApproval;

    public function __construct(mappingApproval $mappingApproval)
    {
        $this->mappingApproval = $mappingApproval;
    }

    public function getByTypeRoleId($aplikasi, $roleId, $regionId)
    {
        return $this->mappingApproval
                    ->where('aplikasi_id', $aplikasi)
                    ->where('role_id', $roleId)
                    ->where('region_id', $regionId);
    }

    public function getByPosition($position, $regionId, $aplikasi)
    {

        return $this->mappingApproval
                    ->where('position', $position)
                    ->where('region_id', $regionId)
                    ->where('aplikasi_id', $aplikasi);
    }
}
