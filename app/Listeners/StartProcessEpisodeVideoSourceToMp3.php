<?php

namespace App\Listeners;

use App\Events\EpisodeAdded;
use App\Jobs\ProcessEpisodeVideoSourceToMp3;
use App\Workflows\NewVideoInPlaylist;
use Workflow\WorkflowStub;

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
        $workflow = WorkflowStub::make(NewVideoInPlaylist::class);
        $workflow->start($event->episode);
    }
}
