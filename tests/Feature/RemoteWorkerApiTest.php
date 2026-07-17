<?php

namespace Tests\Feature;

use App\Events\EpisodeAdded;
use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Workflows\NewVideoInPlaylist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Workflow\WorkflowStub;

class RemoteWorkerApiTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(): array
    {
        return ['Authorization' => 'Bearer ' . config('services.worker.token')];
    }

    private function makeEpisode(array $attributes = []): Episode
    {
        // The real EpisodeAdded listeners (YouTube metadata lookup, workflow
        // auto-start) aren't relevant here; each test drives the workflow
        // lifecycle explicitly instead.
        Event::fake([EpisodeAdded::class]);

        $user = User::factory()->create();
        $feed = Feed::create(['user_id' => $user->id, 'title' => 'Test Feed']);

        return Episode::create(array_merge([
            'feed_id' => $feed->id,
            'title' => 'Test Episode',
            'source_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'status' => 'queued_remote',
        ], $attributes));
    }

    public function test_next_returns_null_when_no_jobs_queued()
    {
        $response = $this->getJson('/api/worker/jobs/next', $this->authHeaders());

        $response->assertOk()->assertJson(['job' => null]);
    }

    public function test_next_rejects_missing_or_invalid_token()
    {
        $this->makeEpisode();

        $this->getJson('/api/worker/jobs/next')->assertStatus(401);
        $this->getJson('/api/worker/jobs/next', ['Authorization' => 'Bearer wrong'])->assertStatus(401);
    }

    public function test_next_claims_a_queued_job_and_hides_it_from_subsequent_calls()
    {
        $episode = $this->makeEpisode();

        $response = $this->getJson('/api/worker/jobs/next', $this->authHeaders());

        $response->assertOk()->assertJson([
            'job' => [
                'episode_id' => $episode->id,
                'uuid' => $episode->uuid,
                'source_url' => $episode->source_url,
            ],
        ]);

        $this->assertNotNull($episode->fresh()->claimed_at);

        $this->getJson('/api/worker/jobs/next', $this->authHeaders())
            ->assertOk()
            ->assertJson(['job' => null]);
    }

    public function test_next_reclaims_a_stale_claim()
    {
        $episode = $this->makeEpisode([
            'claimed_at' => now()->subMinutes(config('youtube.remote-worker-stale-claim-minutes') + 5),
        ]);

        $this->getJson('/api/worker/jobs/next', $this->authHeaders())
            ->assertOk()
            ->assertJson(['job' => ['episode_id' => $episode->id]]);
    }

    public function test_complete_uploads_file_and_resumes_workflow_to_published()
    {
        // Real signal delivery resumes the workflow via a queued job, which
        // needs an actual worker process running to observe synchronously in
        // a test. WorkflowStub::fake() makes signals resume the workflow
        // inline instead, which is the package's own supported way to drive
        // a workflow to completion within a single test process.
        WorkflowStub::fake();

        Storage::fake('download');
        config(['youtube.remote-download-enabled' => true]);

        $episode = $this->makeEpisode(['status' => 'pending']);

        $workflow = WorkflowStub::make(NewVideoInPlaylist::class);
        $episode->update(['workflow_id' => $workflow->id()]);
        $workflow->start($episode->id);

        $episode->refresh();
        $this->assertSame('queued_remote', $episode->status);

        $file = UploadedFile::fake()->create('episode.mp3', 50, 'audio/mpeg');

        $response = $this->post(
            "/api/worker/jobs/{$episode->id}/complete",
            ['file' => $file],
            $this->authHeaders()
        );

        $response->assertOk()->assertJson(['status' => 'ok']);

        Storage::disk('download')->assertExists($episode->uuid . '.mp3');

        $episode->refresh();
        $this->assertSame('published', $episode->status);
        $this->assertSame('path', $episode->mp3_location_type);
        $this->assertSame($episode->uuid . '.mp3', $episode->mp3_location);
        $this->assertNull($episode->claimed_at);
    }

    public function test_complete_rejects_episode_not_awaiting_remote_download()
    {
        Storage::fake('download');
        $episode = $this->makeEpisode(['status' => 'pending']);
        $file = UploadedFile::fake()->create('episode.mp3', 10, 'audio/mpeg');

        $this->post("/api/worker/jobs/{$episode->id}/complete", ['file' => $file], $this->authHeaders())
            ->assertStatus(409);
    }

    public function test_fail_signals_workflow_and_episode_ends_up_failed()
    {
        WorkflowStub::fake();
        config(['youtube.remote-download-enabled' => true]);

        $episode = $this->makeEpisode(['status' => 'pending']);

        $workflow = WorkflowStub::make(NewVideoInPlaylist::class);
        $episode->update(['workflow_id' => $workflow->id()]);
        $workflow->start($episode->id);

        $episode->refresh();
        $this->assertSame('queued_remote', $episode->status);

        // The controller's response is 'ok' (the signal was delivered), but
        // resuming the workflow inline (via fake()) also runs its failure
        // path synchronously in this same call, which rethrows after marking
        // the episode failed - that's the workflow's existing behavior
        // (app/Workflows/NewVideoInPlaylist.php's catch block), surfaced
        // directly here because of fake()+APP_DEBUG rather than going
        // through a real queue worker's job-failure handling.
        try {
            $this->postJson(
                "/api/worker/jobs/{$episode->id}/fail",
                ['error' => 'yt-dlp: video unavailable'],
                $this->authHeaders()
            );
        } catch (\Throwable $e) {
            $this->assertStringContainsString('Remote download failed', $e->getMessage());
        }

        $episode->refresh();
        $this->assertSame('failed', $episode->status);
    }
}
