<?php

namespace App\Workflows\Activities;

use App\Models\Episode;
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
            "You are given the transcription and title of a youtube video:",
            "<transcription>",
            $episode->transcription,
            "</transcription>",
            "<title>",
            $episode->title,
            "</title>",
            "If the title is a question, provide the answer to the question, otherwise make a question from the title and answer it",
            "The answer has to come from the transcription. Answer with bullet points when appropriate. If the transcript doesn't have the answer or don't know or can't answer the question, DO NOT make up an answer, answer with 'I don't know'",
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

        $answer = json_decode($text);

        $episode->update([
            'answer_question' => $answer->question,
            'answer_answer' => $answer->answer,
            'status' => 'answered'
        ]);

        return $episode;
    }
}
