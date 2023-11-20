<?php

namespace AlgoYounes\StatsDPlus\Core;

use Throwable;

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

    public function incr(string $metric, int $delta = 1, float $rate = 1, array $tags = []): void
    {
        $this->client->increment($metric, $delta, $rate, $tags);
    }

    public function decr(string $metric, int $delta = 1, float $rate = 1, array $tags = []): void
    {
        $this->client->decrement($metric, $delta, $rate, $tags);
    }

    /**
     * Captures a unique occurrence of a specified metric.
     *
     * @param string $metric The name of the metric.
     * @param string|int $value The unique element to be counted.
     * @param array $tags Additional contextual information tags.
     */
    public function captureUniqueElement(string $metric, string|int $value, array $tags = []): void
    {
        $this->client->setUniqueElement($metric, $value, $tags);
    }

    public function trackRate(string $metric, float $value, array $tags = []): void
    {
        $this->client->gauge($metric, $value, $tags);
    }

    public function trackError(string $metric, Throwable $error, array $tags = []): void
    {
        $this->client->trackError($metric, $error, $tags);
    }
}
