<?php

namespace App\Workflows\Activities;

use App\Models\Episode;
use Illuminate\Support\Facades\Storage;
use Workflow\Activity;

class TranscribeAudioFile extends Activity
{
    public $tries = 3;

    public function execute(Episode $episode)
    {
        if ($episode->status !== 'downloaded' || empty($episode->mp3_location)) {
            throw new \Exception("Episode {$episode->uuid} is not downloaded");
        }

        $client = \OpenAI::client(config('services.openai.api_key'));

        $object = $client->audio()->transcribe([
            'model' => 'whisper-1',
            'prompt' => 'The audio will never be in Welsh. Use the following text to help identify the language : ' . $episode->title,
            'file' => fopen(Storage::disk('download')->path($episode->mp3_location), 'r'),
            'response_format' => 'verbose_json',
            'timestamp_granularities' => ['segment', 'word'],
        ]);

        try {
            $episode->update([
                'status' => 'transcribed',
                'transcription' => $object->text
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Transcription failed for episode {$episode->uuid}");
        }

        return $episode;
    }
}
