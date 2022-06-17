<?php

namespace App\Services\Support;

use App\Services\first_time_syncService as SupportService;
use Illuminate\Support\Facades\Facade;

class first_time_syncService extends Facade
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
