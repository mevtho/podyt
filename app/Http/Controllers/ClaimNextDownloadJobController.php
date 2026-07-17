<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimNextDownloadJobController extends Controller
{
    public function __invoke(Request $request)
    {
        $staleThreshold = now()->subMinutes(config('youtube.remote-worker-stale-claim-minutes'));

        $episode = DB::transaction(function () use ($staleThreshold) {
            $episode = Episode::query()
                ->where('status', 'queued_remote')
                ->where(function ($query) use ($staleThreshold) {
                    $query->whereNull('claimed_at')
                        ->orWhere('claimed_at', '<', $staleThreshold);
                })
                ->orderBy('created_at')
                ->lockForUpdate()
                ->first();

            $episode?->update(['claimed_at' => now()]);

            return $episode;
        });

        if (!$episode) {
            return response()->json(['job' => null]);
        }

        return response()->json([
            'job' => [
                'episode_id' => $episode->id,
                'uuid' => $episode->uuid,
                'source_url' => $episode->source_url,
            ],
        ]);
    }
}
