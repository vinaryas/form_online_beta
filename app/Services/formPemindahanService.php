<?php

namespace App\Services;

use App\Models\formPemindahan;

class formPemindahanService
{
   private $formPemindahan;

   public function __construct(formPemindahan $formPemindahan)
    {
        $this->formPemindahan = $formPemindahan;
    }

   public function all()
	{
		return $this->formPemindahan->query()->with('form_head');
	}

    public function store($data){
        return $this->formPemindahan->create($data);
    }

}
