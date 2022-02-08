<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedSource extends Model
{
    use HasFactory;

    const TYPE_YOUTUBE_PLAYLIST = 'youtube_playlist';

    protected $appends = ['sourceUrl'];

    protected $fillable = [
        'feed_id',
        'name',
        'type',
        'type_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'feed_id' => 'integer',
        'error_count' => 'integer'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function getSourceUrlAttribute()
    {
        switch ($this->type) {
            case self::TYPE_YOUTUBE_PLAYLIST:
                return "https://www.youtube.com/playlist?list=" . $this->type_id;
            default:
                return "";
        }
    }
}
