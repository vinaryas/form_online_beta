<?php

namespace App\Services;

use App\Models\mappingApprovalPenghapusan;

class MappingApprovalPenghapusanService
{
    private $mappingApprovalPenghapusan;

    public function __construct(mappingApprovalPenghapusan $mappingApprovalPenghapusan)
    {
        $this->mappingApprovalPenghapusan = $mappingApprovalPenghapusan;
    }

    public function getByTypeRoleId($aplikasi, $roleId, $regionId)
    {
        return $this->mappingApprovalPenghapusan
                    ->where('aplikasi_id', $aplikasi)
                    ->where('role_id', $roleId)
                    ->where('region_id', $regionId);
    }

    public function getByPosition($position, $regionId, $aplikasi)
    {

        return $this->mappingApprovalPenghapusan
                    ->where('position', $position)
                    ->where('region_id', $regionId)
                    ->where('aplikasi_id', $aplikasi);
    }
}
