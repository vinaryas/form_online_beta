<?php

namespace App\Services;

use App\Models\first_time_sync;

class first_time_syncService
{
    private $first_time_sync;

    public function __construct(first_time_sync $first_time_sync)
    {
        $this->first_time_sync = $first_time_sync;
    }

    public function all()
    {
        return $this->first_time_sync->query();
    }

    public function update($data, $stores)
    {
        return $this->first_time_sync->where('stores', $stores)->update($data);
    }
}
