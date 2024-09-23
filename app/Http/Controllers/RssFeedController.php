<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Torann\PodcastFeed\Facades\PodcastFeed;

class RssFeedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Feed $feed)
    {
        $feed->load(['user', 'episodes' => fn($query) => $query->published()->orderBy('created_at', 'asc')]);

        PodcastFeed::setHeader([
            'title'       => $feed->title,
            'subtitle'    => '',
            'description' => $feed->description,
            'link'        => config('app.url'),
            'image'       => $feed->coverUrl,
            'author'      => $feed->user->name,
            'owner'       => $feed->user->name,
            'email'       => $feed->user->email,
            'category'    => '',
            'language'    => 'en-us',
            'copyright'   => '',
        ]);

        switch ($feed->mode) {
            case Feed::FEED_PODCAST:
                $this->asPodcastContent($feed);
                break;
            case Feed::FEED_ANSWER:
                $this->asAnswerContent($feed);
                break;
        }

        return Response::make(PodcastFeed::toString())
            ->header('Content-Type', 'text/xml');
    }

    private function asPodcastContent(Feed $feed) {
        foreach($feed->episodes as $episode)
        {
            PodcastFeed::addMedia([
                'title'       => $episode->title,
                'description' => $episode->title,
                'publish_at'  => $episode->created_at->format(\DateTime::RSS),
                'guid'        => $episode->uuid,
                'url'         => $episode->episodeFileUrl(),
                'type'        => 'mp3',//$episode->media_content_type,
                'duration'    => $episode->duration,
                'image'       => $episode->picture_url,
            ]);
        }
    }

    private function asAnswerContent(Feed $feed) {
        foreach($feed->episodes as $episode)
        {
            PodcastFeed::addMedia([
                'title'       => $episode->title,
                'description' => $episode->answer_answer,
                'publish_at'  => $episode->created_at->format(\DateTime::RSS),
                'guid'        => $episode->uuid,
            ]);
        }
    }
}
