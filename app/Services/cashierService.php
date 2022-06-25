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
}
