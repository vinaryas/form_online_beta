<?php

namespace App\Services\Support;

use App\Services\rrakService as SupportService;
use Illuminate\Support\Facades\Facade;

class rrakService extends Facade
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
