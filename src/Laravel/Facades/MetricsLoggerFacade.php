<?php

namespace AlgoYounes\StatsDPlus\Laravel\Facades;

use AlgoYounes\StatsDPlus\Core\MetricsLogger;
use Illuminate\Support\Facades\Facade;

class MetricsLoggerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MetricsLogger::class;
    }
}
