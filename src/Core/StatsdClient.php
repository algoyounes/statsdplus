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

    public function increment(string $key, int $value = 1, int $rate = 1, array $tags = []): void
    {
        $this->attempt(fn() => $this->leagueClient->increment($key, $value, $rate, $tags));
    }

    public function decrement(string $key, int $value = 1, int $rate = 1, array $tags = []): void
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

    private function attempt(callable $callable): void
    {
        try {
            $callable();
        } catch (Exception $e) {
            // do nothing
        }
    }
}
