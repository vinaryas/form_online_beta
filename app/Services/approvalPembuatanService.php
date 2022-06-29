<?php

namespace App\Services;

use App\Models\approvalPembuatan;
use App\Services\Support\MappingApprovalPembuatanService;
use Illuminate\Support\Facades\DB;

class approvalPembuatanService
{
    private $approvalPembuatan;

    public function __construct(approvalPembuatan $approvalPembuatan)
    {
        $this->approvalPembuatan = $approvalPembuatan;
    }

    public function all()
    {
        return $this->approvalPembuatan->query()->with('formPembuatan', 'form', 'user', 'role');
    }

    public function store($data)
    {
        return $this->approvalPembuatan->create($data);
    }

    public function getNextApp($aplikasi, $roleId, $regionId){
        $thisPosition = MappingApprovalPembuatanService::getByTypeRoleId($aplikasi, $roleId, $regionId)->first()->position;

        $nextPosition = MappingApprovalPembuatanService::getByPosition($thisPosition + 1, $regionId, $aplikasi)->first();

        return ($nextPosition != null) ? $nextPosition->role_id : 0;
    }

    public function getDetail()
    {
        $data = DB::table('approval_pembuatan')
        ->join('form_pembuatan', 'approval_pembuatan.form_pembuatan_id', '=', 'form_pembuatan.id')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.created_by', '=', 'users.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_pembuatan.id as form_pembuatan_id',
            'form_head.id as form_id',
            'users.id as user_id',
            'approval_pembuatan.approver_nik as approver_nik',
            'approval_pembuatan.approver_name as approver_name',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
            'users.username',
            'users.name',
            'users.role_id as role_id',
            'form_pembuatan.pass',
            'form_pembuatan.store',
            'form_pembuatan.type',
            'approval_pembuatan.status',
            'approval_pembuatan.created_at',
        );

        return $data;
    }

    public function getStatusApprovalById($id){
        return $this->getDetail()->where('form_pembuatan.id', $id);
    }

    public function getApproval($formPembuatanId, $roleId, $regionId){
        return $this->all()
        ->where('form_pembuatan_id', $formPembuatanId)
        ->where('approver_role_id', $roleId)
        ->where('approver_region_id', $regionId);
    }

    public function isApprovalExitst($formPembuatanId, $roleId, $regionId){
        if($this->getApproval($formPembuatanId, $roleId, $regionId)->count() > 0){
            return true;
        }

        return false;
    }

    public function countApproved($userId){
        return $this->getDetail()
        ->where('approval_pembuatan.status', 'Approved')
        ->where('users.id', $userId);
    }

    public function countDisapproved($userId){
        return $this->getDetail()
        ->where('approval_pembuatan.status', 'Disapproved')
        ->where('users.id', $userId);
    }

    public function countApprovedAdmin(){
        return $this->getDetail()
        ->where('approval_pembuatan.status', 'Approved');
    }

    public function countDisapprovedAdmin(){
        return $this->getDetail()
        ->where('approval_pembuatan.status', 'Disapproved');
    }

}
