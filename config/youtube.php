<?php

/*
|--------------------------------------------------------------------------
| Laravel PHP Facade/Wrapper for the Youtube Data API v3
|--------------------------------------------------------------------------
|
| Here is where you can set your key for Youtube API. In case you do not
| have it, it can be acquired from: https://console.developers.google.com
*/

return [
    'youtube-dl-bin' => env('YOUTUBE_DL_BINARY'),

    'youtube-dl-proxies' => explode(",", env('YOUTUBE_DL_USE_PROXIES', "")),

    'ffmpeg-bin' => env('FFMPEG_BINARY'),

    'remote-download-enabled' => env('YOUTUBE_REMOTE_DOWNLOAD_ENABLED', false),

    'remote-download-timeout' => env('YOUTUBE_REMOTE_DOWNLOAD_TIMEOUT', '3 days'),

    'remote-worker-stale-claim-minutes' => env('YOUTUBE_REMOTE_WORKER_STALE_CLAIM_MINUTES', 30),

    'processing-stuck-days' => env('YOUTUBE_PROCESSING_STUCK_DAYS', 3),
];
