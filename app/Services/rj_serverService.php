<?php

namespace App\Services;

use App\Models\rj_server;
use Illuminate\Support\Facades\DB;

class rj_serverService{
    private $rj_server;

    public function __construct(rj_server $rj_server)
    {
        $this->rj_server = $rj_server;
    }

    public function all(){
        return $this->rj_server->query();
    }

    public function store($data){
        return $this->rj_server->create($data);
    }

    public function update($data, $id){
        return $this->rj_server->where('id', $id)->update($data);
    }

    public function getDetail(){
        $data = DB::table('rj_server')
        ->join('stores', 'stores.id', '=', 'rj_server.store')
        ->select(
            'rj_server.id as id',
            'stores.id as store_id',
            'rj_server.store as store',
            'stores.name as nama_store',
            'stores.email as email_store',
            'rj_server.cashnum as cashnum',
            'rj_server.nama as nama',
            'rj_server.status as status',
        );

        return $data;
    }

    public function getAll($store){
        return $this->getDetail()
        ->where('roles', 0)
        ->where('store', $store);
    }

    public function getById($id){
        return $this->getDetail()->where('rj_server.id', $id);
    }
}

