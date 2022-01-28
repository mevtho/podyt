<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedSource extends Model
{
    use HasFactory;

    const TYPE_YOUTUBE_PLAYLIST = 'youtube_playlist';

    protected $fillable = [
        'feed_id',
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
}
