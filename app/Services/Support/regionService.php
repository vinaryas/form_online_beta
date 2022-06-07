<?php

namespace App\Services\Support;

use App\Services\regionService as SupportService;
use Illuminate\Support\Facades\Facade;

class regionService extends Facade
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
