<?php

namespace App\Models;

use Alaouy\Youtube\Facades\Youtube;
use App\Traits\HasSlug;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Feed extends Model
{
    use HasFactory;
    use HasUuid;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'description',
        'slug',
        'available'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'available' => 'boolean'
    ];

    protected $appends = ['coverUrl', 'rssUrl'];

    protected $slugSource = 'title';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (self $feed) {
            $feed->externalid = uniqid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function sources()
    {
        return $this->hasMany(FeedSource::class);
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', '=', $user->id);
    }

    public function getCoverUrlAttribute()
    {
        if ($this->cover_photo_path && Storage::disk('public')->exists($this->cover_photo_path)) {
            return Storage::disk('public')->url($this->cover_photo_path);
        } else {
            return asset('img/default-cover.png');
        }
    }

    public function getRssUrlAttribute()
    {
        if ($this->available) {
            return route('feed.rss', ["externalFeed" => $this->externalid]);
        } else {
            return '';
        }
    }

    public function addEpisode($url): Episode
    {
        return $this->episodes()->save(new Episode(
            [
                'title' => $url,
                'source_url' => $url,
                'status' => Episode::STATUS_PENDING
            ]
        ));
    }

    public function syncSources($sources)
    {
        $playlistIds = collect($sources)->map(function ($url) {
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            return $query['list'];
        });

        $playlists = Youtube::getPlaylistById($playlistIds->all());

        $this->sources()->delete();
        $this->sources()->saveMany(collect($playlists)->map(function ($playlist) {
            return new FeedSource([
                'name' => $playlist->snippet->title,
                'type' => FeedSource::TYPE_YOUTUBE_PLAYLIST,
                'type_id' => $playlist->id
            ]);
        }));
    }
}
