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

    'ffmpeg-bin' => env('FFMPEG_BINARY')
];
