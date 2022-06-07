<?php

namespace App\Services;

use App\Models\region;

class regionService
{
   private $region;

   public function __construct(region $region)
    {
        $this->region = $region;
    }

   public function all()
	{
		return $this->region->query();
	}

}
