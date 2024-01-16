<?php

namespace App\Jobs;

use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteDownloads implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Deleting downloads ...');

        $expiredDownloads = Episode::whereNotNull('delete_download_at')->where('delete_download_at', '<', now())->get();

        Log::info('Found ' . $expiredDownloads->count() . ' episodes to delete');

        $expiredDownloads->each(function ($episode) {
            Log::info('Deleting download for episode ' . $episode->id);
            $episode->deleteDownload();
        });
    }
}
