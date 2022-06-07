<?php

namespace App\Services\Support;

use App\Services\MappingApprovalService as SupportService;
use Illuminate\Support\Facades\Facade;

class MappingApprovalService extends Facade
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
