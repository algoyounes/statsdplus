<?php

use AlgoYounes\StatsDPlus\Core\MetricsLogger;

function getMetricsLogger(): MetricsLogger
{
    return app(MetricsLogger::class);
}

if (!function_exists('statsd_time')) {
    function statsd_time(string $metric, callable $callable, array $tags = []): void
    {
        getMetricsLogger()->time($metric, $callable, $tags);
    }
}

if (!function_exists('statsd_startTimer')) {
    function statsd_startTimer(string $metric): void
    {
        getMetricsLogger()->startTimer($metric);
    }
}

if (!function_exists('statsd_endTimer')) {
    function statsd_endTimer(string $metric, array $tags = []): void
    {
        getMetricsLogger()->endTimer($metric, $tags);
    }
}

if (!function_exists('statsd_incr')) {
    function statsd_incr(string $metric, int $delta = 1, $rate = 1, array $tags = []): void
    {
        getMetricsLogger()->incr($metric, $delta, $rate, $tags);
    }
}

if (!function_exists('statsd_decr')) {
    function statsd_decr(string $metric, int $delta = 1, $rate = 1, array $tags = []): void
    {
        getMetricsLogger()->decr($metric, $delta, $rate, $tags);
    }
}
