<?php

namespace App\Services;

use App\Models\bap;
use App\Models\rrak;

class bapService{

    private $bap;

    public function __construct(bap $bap)
    {
        $this->bap = $bap;
    }

    public function store($data){
        return $this->bap->create($data);
    }
}
