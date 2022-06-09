<?php

namespace App\Services;

use App\Models\vega;
use PhpParser\Node\Stmt\Return_;

class vegaService{

    private $vega;

    public function __construct(vega $vega)
    {
        $this->vega = $vega;
    }

    public function store($data){
        return $this->vega->create($data);
    }
}
