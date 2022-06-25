<?php

namespace App\Services;

use App\Models\alasanPenghapusan;

class alasanPenghapusanService
{
    private $alasanPenghapusan;

    public function __construct(alasanPenghapusan $alasanPenghapusan)
    {
        $this->alasanPenghapusan = $alasanPenghapusan;
    }

    public function all(){
        return $this->alasanPenghapusan->query();
    }
}
