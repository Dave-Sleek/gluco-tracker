<?php

namespace App\Traits;

use Cronitor\Client;
use Exception;

trait MonitorsWithCronitor
{
    protected string $monitorKey = '';

    public function handleWithMonitoring()
    {
        $client = new Client(config('services.cronitor.api_key'));
        $monitor = $client->monitor($this->monitorKey);

        try {
            $monitor->ping(['state' => 'run']);

            $this->handle(); // Run the original job logic

            $monitor->ping(['state' => 'complete']);
        } catch (Exception $e) {
            $monitor->ping(['state' => 'fail']);
            throw $e; // Let Laravel handle retries/logging
        }
    }
}
