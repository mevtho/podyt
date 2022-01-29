<?php

namespace App\Jobs;

use Alaouy\Youtube\Facades\Youtube;
use App\Models\Episode;
use App\Models\FeedSource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessSourceYoutubePlaylist implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public FeedSource $source;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FeedSource $source)
    {
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->source->type !== FeedSource::TYPE_YOUTUBE_PLAYLIST) {
            return;
        }

        try {
            $items = Youtube::getPlaylistItemsByPlaylistId($this->source->type_id);

            collect($items["results"])->each(function ($item) {
                switch ($item->snippet->resourceId->kind) {
                    case "youtube#video":
                        $videoUrl = "https://www.youtube.com/watch?v=" . $item->snippet->resourceId->videoId;
                        if ($this->source->feed()
                            ->where('source_url', '=', $videoUrl)
                            ->doesntExist()) {
                            Log::info("Processing ..." . $videoUrl);
                            $this->source->feed->addEpisode($videoUrl);
                        }
                        break;
                }
            });

            $this->source->error_count = 0;
            $this->source->save();
        } catch(\Throwable $t) {
            dump($t->getMessage());
            $this->source->error_count++;
            $this->source->save();
        }
    }
}
