<?php

namespace App\Console;

use App\Jobs\DailyMetricsTask;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Cronitor\Cronitor;


class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */

    protected function schedule(Schedule $schedule): void
    {
        // Example: Run your custom notification command every 5 minutes
        $schedule->command('notifications:send-pending')->everyFiveMinutes();
        $schedule->command('reminders:send')->everyMinute(); // or ->hourly(), etc.

        // $schedule->job(new DailyMetricsTask)
        $schedule->call(function () {
            (new DailyMetricsTask)->handleWithMonitoring();
        })->everyMinute();
        
    }
}
