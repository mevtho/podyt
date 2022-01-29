<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $plans = [
            (object) [
                'name' => 'Discovery',
                'price' => (object) [
                    'month' => 0,
                    'year' => 0,
                ],
                'description' => 'Try Out For Free',
                'features' => [
                    '1 Feed',
                    '3 Episodes (video)',
                    'Up to 10 minutes per episode',
                    'Up to 10 downloads per episode',
                    'Add episodes manually'
                ]
            ],
            (object) [
                'name' => 'Personal',
                'price' => (object) [
                    'month' => 12,
                    'year' => 99,
                ],
                'description' => 'A feed for your personal needs',
                'features' => [
                    'Unlimited Feeds',
                    'Unlimited Episodes',
                    '2 months audio storage',
                    'Up to 2 hours per episode',
                    'Up to 10 downloads per episode',
                    'Youtube list watcher for automated delivery'
                ]
            ],
            (object) [
                'name' => 'Publisher',
                'price' => (object) [
                    'month' => 29,
                    'year' => 297,
                ],
                'description' => 'Automate publishing your podcast to the world',
                'features' => [
                    'Unlimited Feeds',
                    'Unlimited Episodes',
                    '6 months audio storage',
                    'Integrate with transistor.fm for podcast hosting',
                    'Youtube list watcher for automated delivery'
                ]
            ],
        ];
        return view('welcome', ['plans' => $plans]);
    }
}
