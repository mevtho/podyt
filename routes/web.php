<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Controllers\WelcomeController::class);

Route::get('/f/{externalFeed}', \App\Http\Controllers\RssFeedController::class)->name('feed.rss');
Route::get('/e/{feedId}/{episode:slug}.mp3', \App\Http\Controllers\DownloadEpisodeController::class)->name('feed.episode.mp3url');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::resource('feed', App\Http\Controllers\FeedController::class);

    Route::resource('feed.episode', App\Http\Controllers\EpisodeController::class);
});

require __DIR__.'/auth.php';


