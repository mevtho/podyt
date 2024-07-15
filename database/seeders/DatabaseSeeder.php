<?php

namespace Database\Seeders;

use App\Models\Feed;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()->createOne([
            'email' => 'test@example.com'
        ]);

        $feed = $user->feeds()->create([
            'title' => 'My Feed',
            'mode' => Feed::FEED_ANSWER,
        ]);

        $feed->addEpisode('https://www.youtube.com/watch?v=QD-tbZo-FPU');
    }
}
