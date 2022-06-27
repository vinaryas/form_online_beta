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

    public function store($data){
        return $this->approvalPenghapusan->create($data);
    }

    public function getNextApp($aplikasi, $roleId, $regionId){
        $thisPosition = MappingApprovalPenghapusanService::getByTypeRoleId($aplikasi, $roleId, $regionId)->first()->position;

        $nextPosition = MappingApprovalPenghapusanService::getByPosition($thisPosition + 1, $regionId, $aplikasi)->first();

        return ($nextPosition != null) ? $nextPosition->role_id : 0;
    }

    public function getDetail()
    {
        $data = DB::table('approval_penghapusan')
        ->join('form_pembuatan', 'approval_penghapusan.form_pembuatan_id', '=', 'form_pembuatan.id')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.created_by', '=', 'users.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'approval_penghapusan.approver_nik as approver_nik',
            'approval_penghapusan.approver_name as approver_name',
            'approval_penghapusan.status',
            'approval_penghapusan.created_at',
            'form_pembuatan.id as form_pembuatan_id',
            'form_pembuatan.pass',
            'form_pembuatan.store',
            'form_pembuatan.type',
            'form_head.id as form_id',
            'users.id as user_id',
            'users.username',
            'users.name',
            'users.role_id as role_id',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
        );

        return $data;
    }

    public function getApproval($formPembuatanId, $roleId, $regionId){
        return $this->all()
        ->where('form_penghapusan_id', $formPembuatanId)
        ->where('approver_role_id', $roleId)
        ->where('approver_region_id', $regionId);
    }

    public function isApprovalExitst($formPembuatanId, $roleId, $regionId){
        if($this->getApproval($formPembuatanId, $roleId, $regionId)->count() > 0){
            return true;
        }

        return false;
    }

}
