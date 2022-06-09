<?php

namespace App\Services;

use App\Models\form;
use App\Models\formAplikasi;
use Illuminate\Support\Facades\DB;

class formAplikasiService
{
   private $formAplikasi;

   public function __construct(formAplikasi $formAplikasi)
    {
        $this->formAplikasi = $formAplikasi;
    }

   public function all()
	{
		return $this->formAplikasi->query()->with('aplikasi', 'form', 'store');
	}

    public function store($data)
    {
        return $this->formAplikasi->create($data);
    }

    public function update($data, $id)
    {
        return $this->formAplikasi->where('id', $id)->update($data);
    }

    public function getDetail()
    {
        //note: bikin yang berelasi terlebih dahulu.
        $data = DB::table('form_aplikasi')
        ->join('form', 'form_aplikasi.form_id', '=', 'form.id')
        ->join('users', 'form.user_id', '=', 'users.id')
        ->join('regions', 'form.region_id', '=', 'regions.id')
        ->leftJoin('stores', 'form.store_id', '=', 'stores.id')
        ->join('dapartemen', 'form.dapartemen_id', '=', 'dapartemen.id')
        ->join('aplikasi', 'form_aplikasi.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_aplikasi.id as form_aplikasi_id',
            'form.id as form_id',
            'form.user_id as user_id',
            'aplikasi.id as aplikasi_id',
            'regions.id as region_id',
            'stores.id as store_id',
            'dapartemen.id as dapartemen_id',
            'form.created_at',
            'form.username',
            'regions.name as nama_region',
            'form_aplikasi.role_last_app',
            'form_aplikasi.role_next_app',
            'stores.name as nama_store',
            'dapartemen.dapartemen',
            'aplikasi.aplikasi',
            'form_aplikasi.pass',
            'users.name'
        );

        return $data;
    }

    public function getFormByUserId($userId){
        return $this->getDetail()->where('user_id', $userId);
    }

    public function adminViewForm(){
        return $this->getDetail();
    }

    public function adminViewApproval(){
        return $this->getDetail()->where('role_next_app', '!=', 0);
    }

    public function getApproveFilter($roleId)
    {
        $formAplikasi = $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('status', 1);

        return $formAplikasi;
    }

    public function getApproveFilterByStore($roleId, $store)
    {
        $formAplikasi = $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('status', 0)
        ->whereIn('store', $store);

        return $formAplikasi;
    }

    public function getFormAplikasiById($formAplikasiId)
    {
        return $this->getDetail()
        ->where('form_aplikasi.id', $formAplikasiId);
    }

    public function getById($id)
    {
        return $this->getdetail()
        ->where('form_aplikasi.id', $id);
    }

    public function getFormByUserIdAllStore($userId){
        return $this->getDetail()
        ->where('form.user_id', $userId)
        ->where('form_aplikasi.status', 1);
    }

    public function getFormByUserIdNonAllStore($userId){
        return $this->getDetail()
        ->where('form.user_id', $userId)
        ->where('form_aplikasi.status', 0);
    }

    public function countApproval($roleId, $store){
        return $this->getDetail()
        ->where('form_aplikasi.role_next_app', $roleId)
        ->where('status', 0)
        ->whereIn('store', $store);
    }

    public function countApprovalIt($roleId){
        return $this->getDetail()->where('form_aplikasi.role_next_app', $roleId);
    }

    public function countAplikasiForAdmin(){
        return $this->getDetail();
    }

}
