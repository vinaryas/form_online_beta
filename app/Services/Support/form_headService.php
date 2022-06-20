<?php

namespace App\Services\Support;

use App\Services\form_headService as SupportService;
use Illuminate\Support\Facades\Facade;

class form_headService extends Facade
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
