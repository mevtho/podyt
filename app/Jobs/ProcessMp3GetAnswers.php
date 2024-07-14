<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessMp3GetAnswers implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Episode $episode;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 1800; // 30 minutes for now, should do better at some point probably

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 1800; // 30 minutes for now, should do better at some point probably

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode->withoutRelations();
        $this->queue = "downloads";
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return $this->episode->id;
    }

    /**
     * Execute the job.
     *
     * Can improve / making more async than simply using queues.
     *  - Start the process and return without waiting for a result
     *  - Process to callback to update status (or have status based on the mp3 file itself
     *
     * @return void
     */
    public function handle()
    {
        if ($this->episode->status !== 'pending_answer') {
            return;
        }

        $this->episode->update([
            'status'=> 'processing_answer'
        ]);

        $ytVideoId = str_replace("https://www.youtube.com/watch?v=", "", $this->episode->source_url);

        $transcription = $this->transcribe($ytVideoId);

        $this->episode->update([
//            'status' => 'pending_answer',
            'transcription' => $transcription,
        ]);

        $answer = $this->getAnswer($this->episode->title, $transcription);

        $answer = json_decode($answer);

        $this->episode->update([
            'status' => 'published',
            'answer_question' => $answer->question,
            'answer_answer' => $answer->answer,
        ]);
    }

    private function transcribe($ytVideoId)
    {
        $client = \OpenAI::client(config('services.openai.api_key'));

        if (!Storage::exists($ytVideoId . ".json") ) {
            $object = $client->audio()->transcribe([
                'model' => 'whisper-1',
                'file' => fopen(Storage::path($ytVideoId . ".mp3"), 'r'),
                'response_format' => 'verbose_json',
                'timestamp_granularities' => ['segment', 'word']
            ]);

            file_put_contents(Storage::path($ytVideoId . ".json"), json_encode($object, JSON_PRETTY_PRINT));
        } else {
            $object = json_decode(file_get_contents(Storage::path($ytVideoId . ".json")));
        }

        return $object->text;
    }

    private function getAnswer($title, $transcription)
    {
        $client = \OpenAI::client(config('services.openai.api_key'));

        $explanation = implode("\n", [
            "You are given the transcription and title of a youtube video:",
            "<transcription>",
            $transcription,
            "</transcription>",
            "<title>",
            $title,
            "</title>",
            "If the title is a question, provide the answer to the question, otherwise make a question from the title and answer it",
            "The answer has to come from the transcription. If the transcript doesn't have the answer or don't know or can't answer the question, DO NOT make up an answer, answer with 'I don't know'",
            "The expected format for this answer is a json object with the following structure:",
            "{ \"question\": \"<question>\", \"answer\": \"<answer>\" }"
        ]);

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $explanation],
            ],
        ]);

        $text = trim($result->choices[0]->message->content);
        if ($text === "I don't know") {
            return false;
        }

        return $text;
    }
}
