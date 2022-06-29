<?php

namespace App\Services;

use App\Models\formPembuatan;
use Illuminate\Support\Facades\DB;

class formPembuatanService
{
   private $formPembuatan;

   public function __construct(formPembuatan $formPembuatan)
    {
        $this->formPembuatan = $formPembuatan;
    }

    public function all(){
		return $this->formPembuatan->query()->with('aplikasi', 'form_head', 'store');
	}

    public function store($data){
        return $this->formPembuatan->create($data);
    }

    public function update($data, $id){
        return $this->formPembuatan->where('id', $id)->update($data);
    }

    public function getDetail(){
        $data = DB::table('form_pembuatan')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.created_by', '=', 'users.id')
        ->join('regions', 'form_head.region_id', '=', 'regions.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->leftJoin('stores', 'form_pembuatan.store', '=', 'stores.id')
        ->select(
            'form_pembuatan.id as form_pembuatan_id',
            'form_pembuatan.aplikasi_id',
            'form_pembuatan.status',
            'form_pembuatan.created_by',
            'form_pembuatan.role_last_app',
            'form_pembuatan.role_next_app',
            'form_pembuatan.pass',
            'form_pembuatan.id_vega as id_vega',
            'form_head.id as form_id',
            'form_head.created_by as user_id',
            'form_head.created_at',
            'form_head.nik',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
            'regions.id as region_id',
            'regions.name as nama_region',
            'users.name',
            'users.username',
            'users.role_id',
            'stores.id as store_id',
            'stores.name as nama_store',
        );

        return $data;
    }

    public function getFormByUserId($userId){
        return $this->getDetail()->where('form_head.created_by', $userId);
    }

    public function getVega(){
        return $this->getDetail()
        ->where('form_pembuatan.aplikasi_id', config('setting_app.aplikasi_id.vega'))
        ->where('form_pembuatan.role_next_app', 0);
    }

    public function getFormForPemindahanByUserId($userId){
        return $this->getDetail()
        ->where('form_head.created_by', $userId)
        ->where( 'form_pembuatan.status', config('setting_app.status_approval.approve'))
        ->where('form_pembuatan.role_next_app', config('setting_app.role_id.finish'));
    }

    public function adminViewApproval(){
        return $this->getDetail()->where('role_next_app', '!=', 0);
    }

    public function getApproveFilter($roleId){
        return $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('status', config('setting_app.status_approval.approve'));
    }

    public function getApproveFilterByStore($roleId, $store){
        return $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('status', config('setting_app.status_approval.panding'))
        ->whereIn('store', $store);
    }

    public function getById($id){
        return $this->getdetail()->where('form_pembuatan.id', $id);
    }

    public function countApprovalIt($roleId){
        return $this->getDetail()->where('form_pembuatan.role_next_app', $roleId);
    }

    public function getDetailApp()
    {
        $data = DB::table('form_pembuatan')
        ->join('approval_pembuatan', 'form_pembuatan.id', '=', 'approval_pembuatan.form_pembuatan_id')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.created_by', '=', 'users.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->leftjoin('stores', 'form_pembuatan.store', '=', 'stores.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_pembuatan.id as form_pembuatan_id',
            'form_pembuatan.pass',
            'form_pembuatan.role_next_app',
            'form_pembuatan.id_vega',
            'form_head.id as form_id',
            'form_head.created_by as user_id',
            'form_head.nik',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
            'roles.id as role_id',
            'roles.display_name',
            'users.name',
            'users.username',
            'stores.id as store_id',
            'approval_pembuatan.status',
        );

        return $data;
    }

    public function getVegaStore(){
        return $this->getDetailApp()
        ->where('aplikasi_id', config('setting_app.aplikasi_id.vega'))
        ->where('approval_pembuatan.status', 'Approved');
    }

    public function getRjServerStore(){
        return $this->getDetailApp()
        ->where('role_next_app', config('setting_app.role_id.aux'))
        ->where('aplikasi_id', config('setting_app.aplikasi_id.rjserver'))
        ->where('approval_pembuatan.status', 'Approved');
    }

    public function getRjServerBo(){
        return $this->getDetailApp()
        ->where('role_next_app', config('setting_app.role_id.it') )
        ->where('aplikasi_id', config('setting_app.aplikasi_id.rjserver'));
    }

    public function getRrakStore(){
        return $this->getDetailApp()
        ->where('aplikasi_id', config('setting_app.aplikasi_id.rrak'))
        ->where('approval_pembuatan.status', 'Approved');
    }

    public function getBapStore(){
        return $this->getDetailApp()
        ->where('aplikasi_id', config('setting_app.aplikasi_id.bap'))
        ->where('approval_pembuatan.status', 'Approved');
    }

}
