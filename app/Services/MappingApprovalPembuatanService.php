<?php

namespace App\Services;

use App\Models\mappingApprovalPembuatan;

class MappingApprovalPembuatanService
{
    private $mappingApprovalPembuatan;

    public function __construct(mappingApprovalPembuatan $mappingApprovalPembuatan)
    {
        $this->mappingApprovalPembuatan = $mappingApprovalPembuatan;
    }

    public function getByTypeRoleId($aplikasi, $roleId, $regionId)
    {
        return $this->mappingApprovalPembuatan
                    ->where('aplikasi_id', $aplikasi)
                    ->where('role_id', $roleId)
                    ->where('region_id', $regionId);
    }

    public function getByPosition($position, $regionId, $aplikasi)
    {

        return $this->mappingApprovalPembuatan
                    ->where('position', $position)
                    ->where('region_id', $regionId)
                    ->where('aplikasi_id', $aplikasi);
    }
}
