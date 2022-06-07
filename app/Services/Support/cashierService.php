<?php

namespace App\Services\Support;

use App\Services\cashierService as SupportService;
use Illuminate\Support\Facades\Facade;

class cashierService extends Facade
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
