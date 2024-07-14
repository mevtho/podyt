<?php

namespace App\Workflows\Activities;

use App\Jobs\ProcessEpisodeVideoSourceToMp3;
use App\Models\Episode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Workflow\Activity;

class DownloadMp3ForVideo extends Activity
{
    public function execute(Episode $episode)
    {
        if ($episode->status !== 'pending') {
            return;
        }

        $episode->update([
            'status'=> 'processing'
        ]);

        $sourceUrl = $episode->source_url;

        // Double check youtube url

        $fileName = $episode->uuid . '.mp3';

        $downloadPath = Storage::disk('download')->path($fileName);

        $cmd = sprintf(
            "%s --extract-audio --audio-format mp3 --prefer-ffmpeg --ffmpeg-location %s --output \"%s\" \"%s\" 2>&1",
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

            $episode->update([
                'status' =>'failed'
            ]);

            return;
        }

        $episode->update([
            'status' =>'published',
            'mp3_location_type' => 'path',
            'mp3_location' => $fileName,
            'delete_download_at' => now()->addDays(7)
        ]);

    }
}
