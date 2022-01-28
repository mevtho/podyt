<?php

namespace App\Events;

use App\Models\Episode;
use Illuminate\Queue\SerializesModels;

class EpisodeAdded
{
    use SerializesModels;

    public Episode $episode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }
}
