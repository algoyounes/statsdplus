# StatsDPlus

StatsDPlus is an enhanced client for interfacing with StatsD, offering an intuitive and flexible way to track application metrics. With seamless Laravel integration and easy-to-use helper functions, StatsDPlus simplifies metrics collection for your PHP applications.

## Features

- Simplified interaction with StatsD for applications.
- Seamless integration with Laravel.
- Easy-to-use helper functions for quick metric logging.
- Supports various metric types including counters, timers, and gauges.

## Installation

Install StatsDPlus using Composer:

```shell
composer require algyounes/statsdplus
```

### Usage

1. Register the laravel service provider in your `config/app.php`:

   ```php
   return [
       // ...
       
      'providers' => [
            // ...
            
            \AlgoYounes\StatsDPlus\Laravel\ServiceProvider::class,
      ],
   ]
   ``` 

2. Set up your StatsD backend in your .env file

   ```shell
   STATSD_PORT=8125
   STATSD_NAMESPACE=shop_platform_test
   STATSD_HOST=statsd.lon3.ibm.youcancorp.com
   ```

3. Start recording your metrics

   ```php
    // Direct use of MetricsLogger
    app(\AlgoYounes\StatsDPlus\Core\MetricsLogger::class)->time('liquid.parse', function () {
        // Time-consuming operation
    });
    
    // Using helper functions
    mt_incr('registrations', 1);
   ```
