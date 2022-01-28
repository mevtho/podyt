<?php

namespace App\Providers;

use App\Events\EpisodeAdded;
use App\Listeners\StartProcessEpisodeVideoSourceToMp3;
use App\Listeners\SetUpUserDefaultFeed;
use App\Listeners\UpdateEpisodeDataFromYoutubeApi;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SetUpUserDefaultFeed::class
        ],
        EpisodeAdded::class => [
            UpdateEpisodeDataFromYoutubeApi::class,
            StartProcessEpisodeVideoSourceToMp3::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
