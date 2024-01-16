<?php

namespace App\Console;

use App\Jobs\CheckYoutubePlaylistSourceUpdates;
use App\Jobs\DeleteDownloads;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new CheckYoutubePlaylistSourceUpdates())->everyMinute();
        $schedule->job(new DeleteDownloads())->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $this->command('test', function () {
            $this->info('test');
            DeleteDownloads::dispatchSync();
            $this->info('dispatched ??');
        });

        require base_path('routes/console.php');
    }
}
