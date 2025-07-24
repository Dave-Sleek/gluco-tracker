<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\MonitorsWithCronitor;

class DailyMetricsTask implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, MonitorsWithCronitor;

    protected string $monitorKey = 'daily-metrics-task';

    public function handle()
    {
        // Your task logic goes here
        // \Log::info("Checked reminders at {$currentTime} on {$currentDay}. Found {$reminders->count()} due.");

        // \Log::info('Running daily metrics processing...');
        // crunch data, send reports, anything you want!
    }
}
