<?php

namespace App\Services\Support;

use App\Services\formPenghapusanService as SupportService;
use Illuminate\Support\Facades\Facade;

class formPenghapusanService extends Facade
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
