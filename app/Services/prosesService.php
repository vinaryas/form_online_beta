<?php

namespace App\Services;

use App\Models\proses;

class prosesService
{
   private $proses;

    public function __construct(proses $proses)
    {
        $this->proses = $proses;
    }

    public function all()
	{
		return $this->proses->query();
	}

    public function pembuatan(){
        return $this->all()->where('id', 1);
    }

    public function penghapusan(){
        return $this->all()->where('id', 2);
    }


}
