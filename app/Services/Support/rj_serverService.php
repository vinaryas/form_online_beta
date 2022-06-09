<?php

namespace App\Services\Support;

use App\Services\rj_serverService as SupportService;
use Illuminate\Support\Facades\Facade;

class rj_serverService extends Facade
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
