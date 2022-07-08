<?php

namespace App\Services;

use App\Models\formPenghapusan;
use Illuminate\Support\Facades\DB;

class formPenghapusanService
{
   private $formPenghapusan;

   public function __construct(formPenghapusan $formPenghapusan)
    {
        $this->formPenghapusan = $formPenghapusan;
    }

   public function all()
	{
		return $this->formPenghapusan->query()->with('form_head');
	}

    public function store($data){
        return $this->formPenghapusan->create($data);
    }

    public function update($data, $id){
        return $this->formPenghapusan->where('id', $id)->update($data);
    }

    public function getDetail(){
        $data = DB::table('form_penghapusan')
        ->join('form_head', 'form_penghapusan.form_id', '=', 'form_head.id')
        ->join('users', 'form_penghapusan.created_by', '=', 'users.id')
        ->join('aplikasi',  'form_penghapusan.aplikasi_id', '=', 'aplikasi.id')
        ->leftJoin('stores', 'form_penghapusan.store', '=', 'stores.id')
        ->join('regions', 'form_head.region_id', '=', 'regions.id')
        ->select(
            'form_penghapusan.id as form_penghapusan_id',
            'form_penghapusan.form_id as form_id',
            'form_penghapusan.role_next_app',
            'form_penghapusan.role_last_app',
            'form_penghapusan.created_by',
            'form_penghapusan.created_at',
            'form_penghapusan.status',
            'stores.id as store_id',
            'stores.name as nama_store',
            'users.name as name',
            'users.username as nik',
            'regions.id as region_id',
            'regions.name as nama_region',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi as aplikasi',
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

    public function adminViewApproval(){
        return $this->getDetail()->where('role_next_app', '!=', 0);
    }

    public function getApproveFilter($roleId){
        return $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('form_penghapusan.status', config('setting_app.status_approval.approve'));
    }

    public function getApproveFilterByStore($roleId, $store){
        return $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('form_penghapusan.status', config('setting_app.status_approval.panding'))
        ->whereIn('store', $store);
    }

    public function getById($id){
        return $this->getdetail()->where('form_penghapusan.id', $id);
    }

    public function getDetailApp()
    {
        $data = DB::table('form_penghapusan')
        ->join('approval_penghapusan', 'form_penghapusan.id', '=', 'approval_penghapusan.form_penghapusan_id')
        ->join('form_head', 'form_penghapusan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.created_by', '=', 'users.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->join('aplikasi', 'form_penghapusan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_penghapusan.id as form_penghapusan_id',
            'form_penghapusan.role_next_app',
            'form_head.id as form_id',
            'form_head.created_by as user_id',
            'form_head.nik',
            'aplikasi.id as aplikasi_id',
            'aplikasi.aplikasi',
            'roles.id as role_id',
            'roles.display_name',
            'users.name',
            'users.username',
            'approval_penghapusan.status',
        );

        return $data;
    }

    public function getRjServerStore()
    {
        return $this->getDetailApp()
        ->where('role_next_app', config('setting_app.role_id.aux'))
        ->where('aplikasi_id', config('setting_app.aplikasi_id.rjserver'))
        ->where('approval_penghapusan.status', 'Approved');
    }


}
