<?php

namespace App\Services;

use App\Models\rrak;

class rrakService{

    private $rrak;

    public function __construct(rrak $rrak)
    {
        $this->rrak = $rrak;
    }

    public function store($data){
        return $this->rrak->create($data);
    }
}
