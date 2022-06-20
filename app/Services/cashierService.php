<?php

namespace App\services;

use App\ModelsConnection\cashier;
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
        $data = DB::table('form_pembuatan')
        ->join('history_pembuatan', 'form_pembuatan.id', '=', 'history_pembuatan.form_pembuatan_id')
        ->join('form_head', 'form_pembuatan.form_id', '=', 'form_head.id')
        ->join('users', 'form_head.user_id', '=', 'users.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->leftJoin('stores', 'form_head.store_id', '=', 'stores.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->join('aplikasi', 'form_pembuatan.aplikasi_id', '=', 'aplikasi.id')
        ->select(
            'form_pembuatan.id as form_pembuatan_id',
            'form_head.id as form_id',
            'form.user_id as user_id',
            'aplikasi.id as aplikasi_id',
            'stores.id as store_id',
            'roles.id as role_id',
            'roles.display_name',
            'form_head.username',
            'users.name',
            'stores.name as nama_store',
            'aplikasi.aplikasi',
            'form_pembuatan.pass',
            'history_pembuatan.status',
            'form_pembuatan.role_next_app'
        );

        return $data;
    }

    public function getPosStore()
    {
        return $this->getDetail()
        ->where('role_next_app', 2)
        ->where('aplikasi_id', 2)
        ->where('history_pembuatan.status', 'Approved');
    }

    public function getPosBO()
    {
        return $this->getDetail()
        ->where('role_next_app', 1)
        ->where('aplikasi_id', 2);
    }
}
