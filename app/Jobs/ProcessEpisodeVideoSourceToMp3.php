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

class ProcessEpisodeVideoSourceToMp3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Episode $episode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
            'mp3_location' => $fileName
        ]);

    }
}
