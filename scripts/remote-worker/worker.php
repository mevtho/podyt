#!/usr/bin/env php
<?php

/**
 * Standalone download worker for podyt's remote-download mode.
 *
 * Run this on a machine that isn't blocked by YouTube (e.g. your laptop, on
 * its normal residential connection). It polls the server for episodes
 * queued with status=queued_remote, downloads them locally with yt-dlp, and
 * uploads the result back. It drains the whole queue then exits, so it's
 * meant to be run periodically (cron/launchd), not kept running.
 *
 * Configure via environment variables (see worker.env.example) and invoke as:
 *   env $(cat worker.env | xargs) php worker.php
 */

$baseUrl = rtrim(getenv('WORKER_BASE_URL') ?: '', '/');
$token = getenv('WORKER_API_TOKEN') ?: '';
$ytDlpBin = getenv('YOUTUBE_DL_BINARY') ?: 'yt-dlp';
$ffmpegBin = getenv('FFMPEG_BINARY') ?: 'ffmpeg';
$tmpDir = getenv('WORKER_TMP_DIR') ?: sys_get_temp_dir();

if ($baseUrl === '' || $token === '') {
    fwrite(STDERR, "WORKER_BASE_URL and WORKER_API_TOKEN must be set.\n");
    exit(1);
}

/**
 * Runs a curl command (without -w/output redirection baked in) and returns
 * the HTTP status, raw body, and decoded JSON (null if the body wasn't
 * valid JSON - e.g. an nginx/PHP error page instead of our API's response).
 */
function httpRequest(string $cmd): array
{
    $raw = shell_exec($cmd . ' -w ' . escapeshellarg("\nHTTP_STATUS:%{http_code}") . ' 2>&1');
    $raw = $raw ?? '';

    $marker = strrpos($raw, "\nHTTP_STATUS:");
    if ($marker === false) {
        return ['status' => 0, 'body' => $raw, 'json' => null];
    }

    $body = substr($raw, 0, $marker);
    $status = (int) trim(substr($raw, $marker + strlen("\nHTTP_STATUS:")));

    return ['status' => $status, 'body' => $body, 'json' => json_decode($body, true)];
}

function apiGet(string $baseUrl, string $token, string $path): array
{
    return httpRequest(sprintf(
        'curl -sS -H %s %s',
        escapeshellarg("Authorization: Bearer {$token}"),
        escapeshellarg($baseUrl . $path)
    ));
}

function apiPostFile(string $baseUrl, string $token, string $path, string $filePath): array
{
    return httpRequest(sprintf(
        'curl -sS -H %s -F %s %s',
        escapeshellarg("Authorization: Bearer {$token}"),
        escapeshellarg('file=@' . $filePath . ';type=audio/mpeg'),
        escapeshellarg($baseUrl . $path)
    ));
}

function apiPostFail(string $baseUrl, string $token, string $path, string $error): array
{
    return httpRequest(sprintf(
        'curl -sS -H %s --data-urlencode %s %s',
        escapeshellarg("Authorization: Bearer {$token}"),
        escapeshellarg('error=' . $error),
        escapeshellarg($baseUrl . $path)
    ));
}

$processed = 0;

while (true) {
    $next = apiGet($baseUrl, $token, '/api/worker/jobs/next');

    if ($next['json'] === null) {
        echo "Failed to fetch next job (HTTP {$next['status']}): {$next['body']}\n";
        break;
    }

    $job = $next['json']['job'] ?? null;

    if (!$job) {
        break;
    }

    $episodeId = $job['episode_id'];
    $sourceUrl = $job['source_url'];
    $outPath = rtrim($tmpDir, '/') . '/' . $job['uuid'] . '.mp3';

    echo "Downloading episode {$episodeId} ({$sourceUrl})...\n";

    $cmd = sprintf(
        '%s --extract-audio --audio-format mp3 --prefer-ffmpeg --ffmpeg-location %s --output %s %s 2>&1',
        $ytDlpBin,
        escapeshellarg($ffmpegBin),
        escapeshellarg($outPath),
        escapeshellarg($sourceUrl)
    );

    $output = shell_exec($cmd);

    if (!file_exists($outPath) || filesize($outPath) === 0) {
        echo "Download failed for episode {$episodeId}:\n{$output}\n";
        apiPostFail($baseUrl, $token, "/api/worker/jobs/{$episodeId}/fail", (string) $output ?: 'yt-dlp produced no output');
        continue;
    }

    $upload = apiPostFile($baseUrl, $token, "/api/worker/jobs/{$episodeId}/complete", $outPath);

    if ($upload['status'] !== 200 || ($upload['json']['status'] ?? null) !== 'ok') {
        echo "Upload failed for episode {$episodeId} (HTTP {$upload['status']}): {$upload['body']}\n";
        echo "Leaving {$outPath} on disk so it isn't re-downloaded; the claim will go stale and can be retried.\n";
        continue;
    }

    echo "Uploaded episode {$episodeId}.\n";

    @unlink($outPath);
    $processed++;
}

echo "Done. Processed {$processed} job(s).\n";
