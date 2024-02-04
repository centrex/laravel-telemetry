<?php

declare(strict_types = 1);

namespace Centrex\Telemetry\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Centrex\Telemetry\Telemetry
 */
class Telemetry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Centrex\Telemetry\Telemetry::class;
    }
}
