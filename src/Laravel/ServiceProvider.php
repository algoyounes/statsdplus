<?php

namespace AlgoYounes\StatsDPlus\Laravel;

use AlgoYounes\StatsDPlus\Core\MetricsLogger;
use AlgoYounes\StatsDPlus\Core\StatsdClient;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../../config/statsd.php' => config_path('statsd.php'),

            ]
        );
    }

    public function register(): void
    {
        $this->app->singleton(MetricsLogger::class, function ($app) {
            $config = $app['config']->get('statsd');
            $client = new StatsdClient($config);

            return new MetricsLogger($client);
        });
    }
}
