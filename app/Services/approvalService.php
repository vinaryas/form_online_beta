<?php

namespace App\Services;

use App\Models\Approval;
use Illuminate\Support\Facades\DB;

class approvalService
{
    private $approval;

    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

    public function all()
    {
        return $this->approval->query()->with('formAplikasi', 'form', 'user', 'role');
    }

    public function store($data)
    {
        return $this->approval->create($data);
    }

    public function getDetail()
    {
        $data = DB::table('history_approval')
        ->join('form_aplikasi', 'history_approval.form_aplikasi_id', '=', 'form_aplikasi.id')
        ->join('form', 'form_aplikasi.form_id', '=', 'form.id')
        ->join('users', 'form.user_id', '=', 'users.id')
        ->join('aplikasi', 'form_aplikasi.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_aplikasi.id as form_aplikasi_id',
            'form.id as form_id',
            'users.id as user_id',
            'history_approval.username as approved_by',
            'history_approval.name as approved_name',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
            'users.username',
            'users.name',
            'users.role_id as role_id',
            'form_aplikasi.pass',
            'form_aplikasi.store',
            'form_aplikasi.type',
            'history_approval.status',
            'history_approval.created_at',
        );

        return $data;
    }

    public function getStatusApprovalById($id){
        return $this->getDetail()->where('form_aplikasi.id', $id);
    }

    public function getApproval($formAplikasiId, $roleId, $regionId)
    {
        return $this->all()
        ->where('form_aplikasi_id', $formAplikasiId)
        ->where('role_id', $roleId)
        ->where('region_id', $regionId);
    }

    public function isApprovalExitst($formAplikasiId, $roleId, $regionId)
    {
        if($this->getApproval($formAplikasiId, $roleId, $regionId)->count() > 0){
            return true;
        }

        return false;
    }

    public function countApproved($userId){
        return $this->getDetail()
        ->where('history_approval.status', 'Approved')
        ->where('users.id', $userId);
    }

    public function countDisapproved($userId){
        return $this->getDetail()
        ->where('history_approval.status', 'Disapproved')
        ->where('users.id', $userId);
    }

    public function countApprovedAdmin(){
        return $this->getDetail()
        ->where('history_approval.status', 'Approved');
    }

    public function countDisapprovedAdmin(){
        return $this->getDetail()
        ->where('history_approval.status', 'Disapproved');
    }

}
