<?php

namespace App\Workflows\Activities;

use App\Models\Episode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Workflow\Activity;

class DownloadMp3ForVideo extends Activity
{
    public $tries = 3;

    public function execute(Episode $episode)
    {
        $sourceUrl = $episode->source_url;

        // Double check youtube url

        $fileName = $episode->uuid . '.mp3';

        $downloadPath = Storage::disk('download')->path($fileName);

        $proxies = $this->getProxyParameter();

        $cmd = sprintf(
            "%s --extract-audio --audio-format mp3 --prefer-ffmpeg --ffmpeg-location %s %s --output \"%s\" \"%s\" 2>&1",
            /* youtube-dl */ config('youtube.youtube-dl-bin'),
            /* --ffmpeg-location */ config('youtube.ffmpeg-bin'),
            $proxies,
            /* --output */ $downloadPath,
            $sourceUrl
        );

        Log::info($cmd);

        $result = shell_exec($cmd);

        if (empty($result) || !Storage::disk('download')->exists($fileName)) {
            if (Storage::disk('download')->exists($fileName)) {
                Storage::disk('download')->delete($fileName);
            }

            throw new \Exception("Download failed for episode {$episode->uuid}");
        }

        $episode->update([
            'status' => 'downloaded',
            'mp3_location_type' => 'path',
            'mp3_location' => $fileName,
            'delete_download_at' => now()->addDays(7)
        ]);

        return $episode;
    }

    private function getProxyParameter() {
        $proxies = config('youtube.youtube-dl-proxies');

        if (empty($proxies)) {
            return "";
        }

        $aProxy = collect($proxies)->random(1)
            ->map(fn ($proxy) => trim($proxy, " \""))
            ->first();

        return $aProxy
            ? "--proxy " . $aProxy
            : "";
    }
}
