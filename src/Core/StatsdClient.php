<?php

namespace AlgoYounes\StatsDPlus\Core;

use League\StatsD\Client as LeagueStatsDClient;
use League\StatsD\Exception\Exception;

class StatsdClient
{
    private LeagueStatsDClient $leagueClient;
    private array $timers = [];

    public function __construct(array $config)
    {
        $this->leagueClient = new LeagueStatsDClient();

        $this->leagueClient->configure($config);
    }

    public function increment(string $key, int $value = 1, float $rate = 1, array $tags = []): void
    {
        $this->attempt(fn() => $this->leagueClient->increment($key, $value, $rate, $tags));
    }

    public function decrement(string $key, int $value = 1, float $rate = 1, array $tags = []): void
    {
        $this->attempt(fn() => $this->leagueClient->decrement($key, $value, $rate, $tags));
    }

    public function startTimer(string $metric): void
    {
        $this->timers[$metric] = microtime(true);
    }

    public function endTimer(string $metric, array $tags = []): void
    {
        if (! isset($this->timers[$metric])) {
            return;
        }

        $duration = microtime(true) - $this->timers[$metric];
        $this->timing($metric, $duration, $tags);

        unset($this->timers[$metric]);
    }

    public function timing(string $key, float $time, array $tags = []): void
    {
        $timeInMilliseconds = (int)($time * 1000);

        $this->attempt(fn() =>  $this->leagueClient->timing($key, $timeInMilliseconds, $tags));
    }

    public function gauge(string $key, int $value, array $tags = []): void
    {
        $this->attempt(fn() => $this->leagueClient->gauge($key, $value, $tags));
    }

    /**
     * Sets a metric with unique elements to track distinct occurrences
     *
     * @param string $key The name of the metric to track.
     * @param string|int $value The unique element to count, e.g., userID, productID.
     * @param array $tags Additional tags for contextual information.
     */
    public function setUniqueElement(string $key, string|int $value, array $tags = []): void
    {
        $this->attempt(fn() => $this->leagueClient->set($key, $value, $tags));
    }

    private function attempt(callable $callable): void
    {
        try {
            $callable();
        } catch (Exception $e) {
            // do nothing
        }
    }
}
