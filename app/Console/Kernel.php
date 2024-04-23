<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // * * * * * cd /home/master/applications/qenmwkwecp/public_html && php artisan queue:work
        // 0 */12 * * * cd /home/master/applications/qenmwkwecp/public_html && php artisan queue:work >/dev/null 2>&1
        // 3:55 pm
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
