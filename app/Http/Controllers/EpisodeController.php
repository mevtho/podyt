<?php

namespace App\Http\Controllers;

use App\Http\Requests\EpisodeStoreRequest;
use App\Http\Requests\EpisodeUpdateRequest;
use App\Models\Episode;
use App\Models\Feed;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Feed $feed)
    {
        return redirect()->to(route('feed.show', $feed));
//        $episodes = Episode::all();
//
//        return view('episode.index', compact('episodes'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Feed $feed)
    {
        abort(404);
        return view('episode.create');
    }

    /**
     * @param \App\Http\Requests\EpisodeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EpisodeStoreRequest $request, Feed $feed)
    {
        $episode = $feed->addEpisode($request->input('source_url'));

        $request->session()->flash('episode.id', $episode->id);

        return redirect()->route('feed.show', ['feed' => $feed]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Episode $episode
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Feed $feed, Episode $episode)
    {
        abort(404);
        return view('episode.show', compact('episode'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Episode $episode
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Feed $feed, Episode $episode)
    {
        abort(404);
        return view('episode.edit', compact('episode'));
    }

    /**
     * @param \App\Http\Requests\EpisodeUpdateRequest $request
     * @param \App\Models\Episode $episode
     * @return \Illuminate\Http\Response
     */
    public function update(EpisodeUpdateRequest $request, Feed $feed, Episode $episode)
    {
        abort(404);
        $episode->update($request->validated());

        $request->session()->flash('episode.id', $episode->id);

        return redirect()->route('feed.episode.index', ['feed' => $feed]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Episode $episode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Feed $feed, Episode $episode)
    {
        $episode->delete();

        return redirect()->route('feed.show', ['feed' => $feed]);
    }
}
