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

   public function all()
	{
		return $this->formPembuatan->query()->with('aplikasi', 'form', 'store');
	}

    public function store($data)
    {
        return $this->formPembuatan->create($data);
    }

    public function update($data, $id)
    {
        return $this->formPembuatan->where('id', $id)->update($data);
    }

    public function getDetail()
    {
        //note: bikin yang berelasi terlebih dahulu.
        $data = DB::table('form_pembuatan')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.user_id', '=', 'users.id')
        ->join('regions', 'form_head.region_id', '=', 'regions.id')
        ->leftJoin('stores', 'form_head.store_id', '=', 'stores.id')
        ->join('departemen', 'form_head.store_id', '=', 'departemen.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_pembuatan.id as form_pembuatan_id',
            'form_pembuatan.aplikasi_id',
            'form_head.id as form_id',
            'form_head.user_id as user_id',
            'aplikasi.id as aplikasi_id',
            'regions.id as region_id',
            'stores.id as store_id',
            'departemen.id as store_id',
            'form_head.created_at',
            'form_head.username',
            'regions.name as nama_region',
            'form_pembuatan.role_last_app',
            'form_pembuatan.role_next_app',
            'stores.name as nama_store',
            'departemen.departemen',
            'aplikasi.aplikasi',
            'form_pembuatan.pass',
            'users.name',
            'form_pembuatan.id_vega as id_vega'
        );

        return $data;
    }

    public function getFormByUserId($userId){
        return $this->getDetail()->where('user_id', $userId);
    }

    public function adminViewForm(){
        return $this->getDetail();
    }

    public function getVega(){
        return $this->getDetail()
        ->where('form_pembuatan.aplikasi_id', 1)
        ->where('form_pembuatan.role_next_app', 0);
    }

    public function adminViewApproval(){
        return $this->getDetail()->where('role_next_app', '!=', 0);
    }

    public function getApproveFilter($roleId)
    {
        $formPembuatan = $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('status', 1);

        return $formPembuatan;
    }

    public function getApproveFilterByStore($roleId, $store)
    {
        $formPembuatan = $this->getDetail()
        ->where('role_next_app', $roleId)
        ->where('status', 0)
        ->whereIn('store', $store);

        return $formPembuatan;
    }

    public function getformPembuatanById($formPembuatanId)
    {
        return $this->getDetail()
        ->where('form_pembuatan.id', $formPembuatanId);
    }

    public function getById($id)
    {
        return $this->getdetail()
        ->where('form_pembuatan.id', $id);
    }

    public function getFormByUserIdAllStore($userId){
        return $this->getDetail()
        ->where('form.user_id', $userId)
        ->where('form_pembuatan.status', 1);
    }

    public function getFormByUserIdNonAllStore($userId){
        return $this->getDetail()
        ->where('form.user_id', $userId)
        ->where('form_pembuatan.status', 0);
    }

    public function countApproval($roleId, $store){
        return $this->getDetail()
        ->where('form_pembuatan.role_next_app', $roleId)
        ->where('status', 0)
        ->whereIn('store', $store);
    }

    public function countApprovalIt($roleId){
        return $this->getDetail()->where('form_pembuatan.role_next_app', $roleId);
    }

    public function countAplikasiForAdmin(){
        return $this->getDetail();
    }

}
