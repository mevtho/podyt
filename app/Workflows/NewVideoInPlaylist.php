<?php

namespace App\Workflows;

use App\Models\Episode;
use App\Models\Feed;
use App\Workflows\Activities\AnswerQuestionFromTranscription;
use App\Workflows\Activities\DownloadMp3ForVideo;
use App\Workflows\Activities\TranscribeAudioFile;
use Workflow\ActivityStub;
use Workflow\SignalMethod;
use Workflow\Workflow;
use Workflow\WorkflowStub;

use Illuminate\Support\Facades\Log;

class NewVideoInPlaylist extends Workflow
{
    private bool $downloadSucceeded = false;

    private bool $downloadFailed = false;

    private ?string $downloadError = null;

    #[SignalMethod]
    public function remoteDownloadSucceeded(): void
    {
        $this->downloadSucceeded = true;
    }

    #[SignalMethod]
    public function remoteDownloadFailed(string $error): void
    {
        $this->downloadFailed = true;
        $this->downloadError = $error;
    }

    public function execute($episodeId)
    {
        $episode = Episode::with('feed')->findOrFail($episodeId);

        try {
            if (config('youtube.remote-download-enabled')) {
                yield WorkflowStub::sideEffect(fn() => $episode->update(['status' => 'queued_remote']));

                $completed = yield WorkflowStub::awaitWithTimeout(
                    config('youtube.remote-download-timeout'),
                    fn() => $this->downloadSucceeded || $this->downloadFailed
                );

                if (!$completed) {
                    throw new \Exception("Timed out waiting for remote worker to download episode {$episode->uuid}");
                }

                if ($this->downloadFailed) {
                    throw new \Exception("Remote download failed for episode {$episode->uuid}: {$this->downloadError}");
                }

                $episode->refresh();
            } else {
                $result = yield WorkflowStub::sideEffect(fn() => $episode->update(['status' => 'processing']));

                $result = yield ActivityStub::make(DownloadMp3ForVideo::class, $episode);
            }

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
