<?php

use AlgoYounes\StatsDPlus\Core\MetricsLogger;

function getMetricsLogger(): MetricsLogger
{
    return app(MetricsLogger::class);
}

if (!function_exists('mt_time')) {
    function mt_time(string $metric, callable $callable, array $tags = []): void
    {
        getMetricsLogger()->time($metric, $callable, $tags);
    }
}

if (!function_exists('mt_startTimer')) {
    function mt_startTimer(string $metric): void
    {
        getMetricsLogger()->startTimer($metric);
    }
}

if (!function_exists('mt_endTimer')) {
    function mt_endTimer(string $metric, array $tags = []): void
    {
        getMetricsLogger()->endTimer($metric, $tags);
    }
}

if (!function_exists('mt_incr')) {
    function mt_incr(string $metric, int $delta = 1, $rate = 1, array $tags = []): void
    {
        getMetricsLogger()->incr($metric, $delta, $rate, $tags);
    }
}

if (!function_exists('mt_decr')) {
    function mt_decr(string $metric, int $delta = 1, $rate = 1, array $tags = []): void
    {
        getMetricsLogger()->decr($metric, $delta, $rate, $tags);
    }
}

if (!function_exists('mt_trackUnique')) {
    function mt_trackUnique(string $metric, string|int $value, array $tags = []): void
    {
        getMetricsLogger()->captureUniqueElement($metric, $value, $tags);
    }
}

if (!function_exists('mt_trackRate')) {
    function mt_trackRate(string $metric, string $value, array $tags = []): void
    {
        getMetricsLogger()->trackRate($metric, $value, $tags);
    }
}

if (!function_exists('mt_trackError')) {
    function mt_trackError(string $metric, Throwable $error, array $tags = []): void
    {
        getMetricsLogger()->trackError($metric, $error, $tags);
    }
}
