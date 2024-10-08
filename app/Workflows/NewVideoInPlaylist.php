<?php

namespace App\Workflows;

use App\Models\Episode;
use App\Models\Feed;
use App\Workflows\Activities\AnswerQuestionFromTranscription;
use App\Workflows\Activities\DownloadMp3ForVideo;
use App\Workflows\Activities\TranscribeAudioFile;
use Workflow\ActivityStub;
use Workflow\Workflow;
use Workflow\WorkflowStub;

use Illuminate\Support\Facades\Log;

class NewVideoInPlaylist extends Workflow
{
    public function execute($episodeId)
    {
        $episode = Episode::with('feed')->findOrFail($episodeId);

        try {
            $result = yield WorkflowStub::sideEffect(fn() => $episode->update(['status' => 'processing']));

            $result = yield ActivityStub::make(DownloadMp3ForVideo::class, $episode);

            if ($episode->feed->mode === Feed::FEED_ANSWER) {
                $result = yield ActivityStub::make(TranscribeAudioFile::class, $episode);

                $result = yield ActivityStub::make(AnswerQuestionFromTranscription::class, $episode);
            }

            $result = yield WorkflowStub::sideEffect(fn() => $episode->update(['status' => 'published']));

            return $result;
        } catch (\Exception $e) {
            Log::error('Workflow Exception : ' . $e->getMessage());

            $episode->update(['status' => 'failed']);

            throw $e;
        }
    }
}
