<?php

namespace App\Services;

use App\Models\rj_server;

class rj_serverService{
    private $rj_server;

    public function __construct(rj_server $rj_server)
    {
        $this->rj_server = $rj_server;
    }

    public function store($data){
        return $this->rj_server->create($data);
    }
}

