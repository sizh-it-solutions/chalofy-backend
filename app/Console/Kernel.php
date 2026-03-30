<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DistributeVendorCommissionJob;
use App\Console\Commands\DeleteLaravelLog;
use App\Jobs\CleanupStaleData;
class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');

    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the job to run every minute
     $schedule->job(new DistributeVendorCommissionJob)->cron('* * * * *');
        // Schedule the log cleaner daily
        $schedule->command('log:clean')->daily();
           $schedule->job(new CleanupStaleData)
       ->cron('* * * * *');
    }

    /**
     * Register custom Artisan commands
     */
    protected $commands = [
        DeleteLaravelLog::class,
    ];
}
