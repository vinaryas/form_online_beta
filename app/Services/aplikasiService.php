<?php

namespace App\Services;

use App\Models\aplikasi;

class aplikasiService
{
   private $aplikasi;

   public function __construct(aplikasi $aplikasi)
    {
        $this->aplikasi = $aplikasi;
    }

   public function all()
	{
		return $this->aplikasi->query()->with('form_head');
	}

}
