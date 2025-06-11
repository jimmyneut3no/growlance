<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Daily rewards distribution at midnight
        // $schedule->command('staking:distribute-rewards')
        //     ->dailyAt('00:00')
        //     ->withoutOverlapping();

        // Check staking maturity every hour
        // $schedule->command('staking:check-maturity')
        //     ->hourly()
        //     ->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 