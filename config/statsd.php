<?php

return [
    'host'                      => env('STATSD_HOST', '127.0.0.1'),
    'port'                      => env('STATSD_PORT', 8125),
    'timeout'                   => env('STATSD_TIMEOUT', 5),
    'throwConnectionExceptions' => (bool)env('STATSD_THROW_CONNECTION_EXCEPTION', true),
    'namespace'                 => env('STATSD_NAMESPACE', 'default_namespace'),
];
