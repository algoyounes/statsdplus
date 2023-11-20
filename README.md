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

1. Register the Laravel service provider in your `config/app.php`:

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
   STATSD_NAMESPACE=my_app_namespace
   STATSD_HOST=my.statsd.server.com
   ```

3. Start recording your metrics

   ```php
    // Direct use of MetricsLogger
    app(\AlgoYounes\StatsDPlus\Core\MetricsLogger::class)->time('operation.duration', function () {
        // Time-consuming operation
    });
    
    // Using helper functions for incrementing a metric
    mt_incr('user.registrations', 1);
   
   // Recording a gauge value
   mt_gauge('memory.usage', $memoryUsage);
   
   // Measure the duration of code execution using mt_startTimer and mt_endTimer :

   // Start the timer for a specific operation
   mt_startTimer('db.query.execution');
   
   // Execute the operation you want to time
   $result = DB::table('users')->get();
   
   // Stop the timer and log the duration
   mt_endTimer('db.query.execution');

   // Tracking Unique Visitors
   // Use `mt_trackUnique` to track the number of unique visitors to a specific page in the application. This method is ideal for understanding user engagement and reach.
   $userID = getCurrentUserID(); // Retrieve the unique user ID
   mt_trackUnique('homepage.unique.visitors', $userID);

   // Tracking Rate
   // `mt_trackRate` can be used to monitor the rate of requests. This is useful for identifying usage patterns and potential bottlenecks.
   $endpoint = '/api/v1/data';
   $requestRate = calculateRequestRate(); // calculate the request rate
   mt_trackRate('api.request.rate', $requestRate, ['endpoint' => $endpoint]);

   // Error Tracking 
   // `mt_trackError` to log errors that occur within your application. This function helps in identifying and responding to issues promptly.
   
   try {
       // Code that might throw an error or exception
   } catch (Throwable $e) {
       mt_trackError('system.errors', $e, ['module' => 'paymentProcessing']);
   }
   
   ```
