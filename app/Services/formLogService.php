<?php

namespace App\Services;

use App\Models\formLog;

class formLogService
{
    private $formLog;

    public function __construct(formLog $formLog)
    {
        $this->formLog = $formLog;
    }

    public function all(){
        return $this->formLog->query();
    }

    public function store($data){
        return $this->formLog->create($data);
    }
}
