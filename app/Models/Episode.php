<?php

namespace App\Models;

use App\Events\EpisodeAdded;
use App\Traits\HasSlug;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Episode extends Model
{
    use HasFactory;
    use HasSlug;
    use HasUuid;

    const STATUS_PENDING = 'pending';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'feed_id',
        'title',
        'duration',
        'slug',
        'source_url',
        'picture_url',
        'mp3_location_type',
        'mp3_location',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'feed_id' => 'integer',
        'duration' => 'integer',
    ];

    public $dispatchesEvents = [
        'created' => EpisodeAdded::class
    ];

    protected $slugSource = 'title';

    public static bool $updatedDataFromYoutube = true;
    public static bool $convertToMP3 = true;

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function readyForDownload()
    {
        return $this->status === 'published'
            && $this->mp3_location_type === 'path'
            && Storage::disk('download')->exists($this->mp3_location);
    }

    public function episodeFileUrl()
    {
        switch ($this->mp3_location_type) {
            case 'path':
                return route('feed.episode.mp3url', $this);
            case 'url':
                return $this->mp3_location;
        }
        return "";
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', 'published');
    }
}
