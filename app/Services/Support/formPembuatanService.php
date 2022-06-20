<?php

namespace App\Services\Support;

use App\Services\formPembuatanService as SupportService;
use Illuminate\Support\Facades\Facade;

class formPembuatanService extends Facade
{
	/**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SupportService::class;
    }
}
