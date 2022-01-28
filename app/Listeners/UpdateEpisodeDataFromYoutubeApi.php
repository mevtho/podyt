<?php

namespace App\Listeners;

use Alaouy\Youtube\Facades\Youtube;
use App\Events\EpisodeAdded;

class UpdateEpisodeDataFromYoutubeApi
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\EpisodeAdded  $event
     * @return void
     */
    public function handle(EpisodeAdded $event)
    {
        $videoId = Youtube::parseVidFromURL($event->episode->source_url);

        $video = Youtube::getVideoInfo($videoId);

        $event->episode->update([
            'title' => $video->snippet->title ?? $event->episode->title,
            'duration' => $this->convertYoutubeDuration($video->contentDetails->duration),
            'picture_url' => $video->snippet->thumbnails->medium->url ?? ''
        ]);
    }

    private function convertYoutubeDuration($youtubeDuration)
    {
        $duration = new \DateInterval($youtubeDuration);

        $seconds = ($duration->s)
            + ($duration->i * 60)
            + ($duration->h * 60 * 60);

        return $seconds;
    }
}
