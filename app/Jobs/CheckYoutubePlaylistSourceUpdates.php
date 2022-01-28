<?php

namespace App\Jobs;

use Alaouy\Youtube\Facades\Youtube;
use App\Models\FeedSource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckYoutubePlaylistSourceUpdates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        FeedSource::query()
            ->where('error_count', '<', 3)
            ->chunk(50, function ($sources) {
            foreach ($sources as $source) {
                ProcessSourceYoutubePlaylist::dispatch($source);
            }
        });
    }
}
