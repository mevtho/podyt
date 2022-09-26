<?php

namespace App\Listeners;

use App\Events\EpisodeAdded;
use App\Jobs\ProcessEpisodeVideoSourceToMp3;

class StartProcessEpisodeVideoSourceToMp3
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\EpisodeAdded  $event
     * @return void
     */
    public function handle(EpisodeAdded $event)
    {
        ProcessEpisodeVideoSourceToMp3::dispatch($event->episode);
    }
}
