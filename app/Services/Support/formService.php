<?php

namespace App\Services\Support;

use App\Services\formService as SupportService;
use Illuminate\Support\Facades\Facade;

class formService extends Facade
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
