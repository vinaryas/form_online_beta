<?php

namespace App\services;

use App\Models\cashier;
use Illuminate\Support\Facades\DB;

class cashierService
{
    private $db;
    private $model;

    public function __construct(cashier $cashier)
    {
        $this->db = DB::connection('mysql2');
        $this->model = $cashier;
    }

    public function all(){
        return $this->model->query();
    }

    public function store($data){
        return $this->model->create($data);
    }

    public function update($data, $id){
        return $this->model->where('id', $id)->update($data);
    }

    public function getById($id){
        return $this->model->where('id', $id);
    }

    public function getDetail()
    {
        $data = DB::table('form_aplikasi')
        ->join('history_approval', 'form_aplikasi.id', '=', 'history_approval.form_aplikasi_id')
        ->join('form', 'form_aplikasi.form_id', '=', 'form.id')
        ->join('users', 'form.user_id', '=', 'users.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->leftJoin('stores', 'form.store_id', '=', 'stores.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->join('aplikasi', 'form_aplikasi.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_aplikasi.id as form_aplikasi_id',
            'form.id as form_id',
            'form.user_id as user_id',
            'aplikasi.id as aplikasi_id',
            'stores.id as store_id',
            'roles.id as role_id',
            'roles.display_name',
            'form.username',
            'users.name',
            'stores.name as nama_store',
            'aplikasi.aplikasi',
            'form_aplikasi.pass',
            'history_approval.status',
            'form_aplikasi.role_next_app'
        );

        return $data;
    }

    public function getPosStore()
    {
        return $this->getDetail()
        ->where('role_next_app', 2)
        ->where('aplikasi_id', 2)
        ->where('history_approval.status', 'Approved');
    }

    public function getPosBO()
    {
        return $this->getDetail()
        ->where('role_next_app', 1)
        ->where('aplikasi_id', 2);
    }
}
