<?php

namespace App\Services;

use App\Models\departemen;

class departemenService
{
   private $departemen;

   public function __construct(departemen $departemen)
    {
        $this->departemen = $departemen;
    }

   public function all()
	{
		return $this->departemen->query();
	}

}
