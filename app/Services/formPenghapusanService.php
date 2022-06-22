<?php

namespace App\Services;

use App\Models\formPenghapusan;

class formPenghapusanService
{
   private $formPenghapusan;

   public function __construct(formPenghapusan $formPenghapusan)
    {
        $this->formPenghapusan = $formPenghapusan;
    }

   public function all()
	{
		return $this->formPenghapusan->query()->with('form_head');
	}

    public function store($data){
        return $this->formPenghapusan->create($data);
    }

}
