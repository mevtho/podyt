<?php

namespace App\Listeners;

use App\Events\EpisodeAdded;
use App\Workflows\NewVideoInPlaylist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Workflow\WorkflowStub;

class StartProcessEpisodeVideoSourceToMp3 implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \App\Events\EpisodeAdded $event
     * @return void
     */
    public function handle(EpisodeAdded $event)
    {
        Log::info('Starting ProcessEpisodeVideoSourceToMp3 job for episode ' . $event->episode->id);

        $workflow = WorkflowStub::make(NewVideoInPlaylist::class);
        $workflow->start($event->episode->id);

        Log::info('Started ProcessEpisodeVideoSourceToMp3 job for episode ' . $event->episode->id);
    }
}
