<?php

namespace App\Workflows;

use App\Models\Episode;
use App\Workflows\Activities\DownloadMp3ForVideo;
use App\Workflows\Activities\TranscribeAudioFile;
use Workflow\ActivityStub;
use Workflow\Workflow;

class NewVideoInPlaylist extends Workflow
{
    public function execute(Episode $episode)
    {
        $result = yield ActivityStub::make(DownloadMp3ForVideo::class, $episode);

        if ($episode->mode === 'answer') {
            $result = yield ActivityStub::make(TranscribeAudioFile::class, $episode);

            $result = yield ActivityStub::make(AnswerQuestionFromTranscription::class, $episode);
        }

        return $result;
    }
}
