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
        return $this->approval->query()->with('formPembuatan', 'form', 'user', 'role');
    }

    public function store($data)
    {
        return $this->approval->create($data);
    }

    public function getDetail()
    {
        $data = DB::table('history_pembuatan')
        ->join('form_pembuatan', 'history_pembuatan.form_pembuatan_id', '=', 'form_pembuatan.id')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.user_id', '=', 'users.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_pembuatan.id as form_pembuatan_id',
            'form_head.id as form_id',
            'users.id as user_id',
            'history_pembuatan.username as approved_by',
            'history_pembuatan.name as approved_name',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
            'users.username',
            'users.name',
            'users.role_id as role_id',
            'form_pembuatan.pass',
            'form_pembuatan.store',
            'form_pembuatan.type',
            'history_pembuatan.status',
            'history_pembuatan.created_at',
        );

        return $data;
    }

    public function getStatusApprovalById($id){
        return $this->getDetail()->where('form_pembuatan.id', $id);
    }

    public function getApproval($formPembuatanId, $roleId, $regionId)
    {
        return $this->all()
        ->where('form_pembuatan_id', $formPembuatanId)
        ->where('role_id', $roleId)
        ->where('region_id', $regionId);
    }

    public function isApprovalExitst($formPembuatanId, $roleId, $regionId)
    {
        if($this->getApproval($formPembuatanId, $roleId, $regionId)->count() > 0){
            return true;
        }

        return false;
    }

    public function countApproved($userId){
        return $this->getDetail()
        ->where('history_pembuatan.status', 'Approved')
        ->where('users.id', $userId);
    }

    public function countDisapproved($userId){
        return $this->getDetail()
        ->where('history_pembuatan.status', 'Disapproved')
        ->where('users.id', $userId);
    }

    public function countApprovedAdmin(){
        return $this->getDetail()
        ->where('history_pembuatan.status', 'Approved');
    }

    public function countDisapprovedAdmin(){
        return $this->getDetail()
        ->where('history_pembuatan.status', 'Disapproved');
    }

}
