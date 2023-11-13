<?php

namespace AlgoYounes\StatsDPlus\Core;

class MetricsLogger
{
    private StatsdClient $client;

    public function __construct(StatsdClient  $client)
    {
        $this->client = $client;
    }

    public function time(string $metric, callable $callable, array $tags = []): void
    {
        try {
            $this->startTimer($metric);

            $callable();
        } finally {
            $this->endTimer($metric, $tags);
        }
    }

    public function startTimer(string $metric): void
    {
        $this->client->startTimer($metric);
    }

    public function endTimer(string $metric, array $tags = []): void
    {
        $this->client->endTimer($metric, $tags);
    }

    /**
     * @param int|float $rate
     */
    public function incr(string $metric, int $delta = 1, $rate = 1, array $tags = []): void
    {
        $this->client->increment($metric, $delta, $rate, $tags);
    }

    /**
     * @param int|float $rate
     */
    public function decr(string $metric, int $delta = 1, $rate = 1, array $tags = []): void
    {
        $this->client->decrement($metric, $delta, $rate, $tags);
    }
}
