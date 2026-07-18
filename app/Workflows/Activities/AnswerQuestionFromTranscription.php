<?php

namespace App\Workflows\Activities;

use App\Models\Episode;
use Illuminate\Support\Str;
use Workflow\Activity;

class AnswerQuestionFromTranscription extends Activity
{
    public $tries = 3;

    public function execute(Episode $episode)
    {
        if ($episode->status !== 'transcribed' || empty($episode->transcription)) {
            throw new \Exception("Episode {$episode->uuid} is not transcribed");
        }

        $client = \OpenAI::client(config('services.openai.api_key'));

        $explanation = implode("\n", [
            "You are given the following transcription and title of a youtube video:",
            "<transcription>",
            $episode->transcription,
            "</transcription>",
            "<title>",
            $episode->title,
            "</title>",
            "If the title is a question, provide the answer to the question, otherwise make a question from the title and answer it",
            "The answer must come from the transcription. Answer with bullet points when appropriate. If the transcript doesn't have the answer, you don't know or you can't answer the question, DO NOT make up an answer, answer with 'I don't know'",
            "The expected format for this answer is a json object with the following structure:",
            "{ \"question\": \"<question>\", \"answer\": \"<answer>\" }"
        ]);

        $result = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                ['role' => 'user', 'content' => $explanation],
            ],
        ]);

        $text = trim($result->choices[0]->message->content);

        // Defensive: some responses still come back wrapped in a markdown code fence
        // despite the json_object response format being requested.
        $text = preg_replace('/^```(?:json)?\s*|\s*```$/', '', $text);

        $answer = json_decode($text);

        if (empty($answer?->question) || empty($answer?->answer)) {
            $reason = json_last_error() !== JSON_ERROR_NONE
                ? json_last_error_msg()
                : 'missing "question" or "answer" field';

            throw new \Exception(sprintf(
                'Invalid answer from OpenAI for episode %s (%s): %s',
                $episode->uuid,
                $reason,
                Str::limit($text, 500)
            ));
        }

        $episode->update([
            'answer_question' => $answer->question,
            'answer_answer' => $answer->answer,
            'status' => 'answered'
        ]);

        return $episode;
    }
}
