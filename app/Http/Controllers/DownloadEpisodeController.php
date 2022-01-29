<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DownloadEpisodeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(Request $request, $feedId, Episode $episode)
    {
        abort_if($episode->feed_id !== $feedId, 404);
        abort_unless($episode->readyForDownload(), 404);

        return Response::file(
            Storage::disk('download')->path($episode->mp3_location)
        );
    }
}
