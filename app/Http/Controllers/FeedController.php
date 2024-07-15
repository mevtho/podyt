<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedSaveRequest;
use App\Models\Episode;
use App\Models\Feed;
use Illuminate\Http\Request;
use Inertia\ResponseFactory;

class FeedController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Feed::class, 'feed');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        $feeds = Feed::forUser($request->user())->withCount('episodes')->orderBy('title', 'asc')->get();

        return Inertia('Feed/Index', [
            'feeds' => $feeds
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(Request $request)
    {
        return Inertia('Feed/Create');
    }

    /**
     * @param \App\Http\Requests\FeedSaveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedSaveRequest $request)
    {
        $feed = new Feed([
            'title' => $request->input('title'),
            'description' => $request->input('description') ?? '',
            'mode' => $request->input('mode')
        ]);

        if ($request->hasFile('cover_photo')) {
            $feed->cover_photo_path = $request->file('cover_photo')->storePublicly('covers', 'public');
        }

        $feed = $request->user()->feeds()->save($feed);

        $feed->syncSources(collect($request->input('sources', [])));

        $request->session()->flash('feed.id', $feed->id);

        return redirect()->route('feed.show', $feed);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feed $feed
     * @return ResponseFactory
     */
    public function show(Request $request, Feed $feed)
    {
        $feed->load(['sources', 'episodes' => fn($query) => $query->orderBy('created_At', 'desc')]);

        $feed->episodes->each(fn(Episode $e) => $e->download_url = $e->episodeFileUrl());

        return Inertia(
            'Feed/Show',
            [
                'feed' => $feed
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feed $feed
     * @return ResponseFactory
     */
    public function edit(Request $request, Feed $feed)
    {
        $feed->load('sources');

        return Inertia(
            'Feed/Edit',
            [
                'feed' => $feed
            ]
        );
    }

    /**
     * @param \App\Http\Requests\FeedSaveRequest $request
     * @param \App\Models\Feed $feed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FeedSaveRequest $request, Feed $feed)
    {
        $feed->title = $request->input('title');
        $feed->description = $request->input('description') ?? '';

        if ($request->hasFile('cover_photo')) {
            $feed->cover_photo_path = $request->file('cover_photo')->storePublicly('covers', 'public');
        }
        $feed->save();

        $request->session()->flash('feed.id', $feed->id);

        $feed->syncSources(collect($request->input('sources', [])));

        $request->session()->flash('feed.id', $feed->id);

        return redirect()->route('feed.show', $feed);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feed $feed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Feed $feed)
    {
        $feed->delete();

        return redirect()->route('feed.index');
    }
}
