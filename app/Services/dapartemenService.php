<?php

namespace App\Services;

use App\Models\dapartemen;

class dapartemenService
{
   private $dapartemen;

   public function __construct(dapartemen $dapartemen)
    {
        $this->dapartemen = $dapartemen;
    }

   public function all()
	{
		return $this->dapartemen->query();
	}

}
