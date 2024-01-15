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
use Illuminate\Support\Facades\Storage;

class ProcessEpisodeVideoSourceToMp3 implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Episode $episode;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 1800; // 30 minutes for now, should do better at some point probably

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 1800; // 30 minutes for now, should do better at some point probably

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode->withoutRelations();
        $this->queue = "downloads";
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return $this->episode->id;
    }

    /**
     * Execute the job.
     *
     * Can improve / making more async than simply using queues.
     *  - Start the process and return without waiting for a result
     *  - Process to callback to update status (or have status based on the mp3 file itself
     *
     * @return void
     */
    public function handle()
    {
        if ($this->episode->status !== 'pending') {
            return;
        }

        $this->episode->update([
            'status'=> 'processing'
        ]);

        $sourceUrl = $this->episode->source_url;

        // Double check youtube url

        $fileName = $this->episode->uuid . '.mp3';

        $downloadPath = Storage::disk('download')->path($fileName);

        $cmd = sprintf(
            "%s --extract-audio --audio-format mp3 --prefer-ffmpeg --ffmpeg-location %s --output %s %s 2>&1",
            /* youtube-dl */ config('youtube.youtube-dl-bin'),
            /* --ffmpeg-location */ config('youtube.ffmpeg-bin'),
            /* --output */ $downloadPath,
            $sourceUrl
        );

        Log::info($cmd);

        $result = shell_exec($cmd);

        if (empty($result) || !Storage::disk('download')->exists($fileName)) {
            if (Storage::disk('download')->exists($fileName)) {
                Storage::disk('download')->delete($fileName);
            }

            $this->episode->update([
                'status' =>'failed'
            ]);

            return;
        }

        $this->episode->update([
            'status' =>'published',
            'mp3_location_type' => 'path',
            'mp3_location' => $fileName,
            'delete_download_at' => now()->addDays(7)
        ]);

    }
}
