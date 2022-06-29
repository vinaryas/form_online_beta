<?php

namespace App\Services\Support;

use App\Services\bapService as SupportService;
use Illuminate\Support\Facades\Facade;

class bapService extends Facade
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
