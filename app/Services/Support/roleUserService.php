<?php

namespace App\Services\Support;

use App\Services\roleUserService as SupportService;
use Illuminate\Support\Facades\Facade;

class roleUserService extends Facade
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
