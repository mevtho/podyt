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

function apiGet(string $baseUrl, string $token, string $path): ?array
{
    $cmd = sprintf(
        'curl -sS -H %s %s',
        escapeshellarg("Authorization: Bearer {$token}"),
        escapeshellarg($baseUrl . $path)
    );

    $output = shell_exec($cmd);

    return $output ? json_decode($output, true) : null;
}

function apiPostFile(string $baseUrl, string $token, string $path, string $filePath): ?array
{
    $cmd = sprintf(
        'curl -sS -H %s -F %s %s',
        escapeshellarg("Authorization: Bearer {$token}"),
        escapeshellarg('file=@' . $filePath . ';type=audio/mpeg'),
        escapeshellarg($baseUrl . $path)
    );

    $output = shell_exec($cmd);

    return $output ? json_decode($output, true) : null;
}

function apiPostFail(string $baseUrl, string $token, string $path, string $error): void
{
    $cmd = sprintf(
        'curl -sS -H %s --data-urlencode %s %s',
        escapeshellarg("Authorization: Bearer {$token}"),
        escapeshellarg('error=' . $error),
        escapeshellarg($baseUrl . $path)
    );

    shell_exec($cmd);
}

$processed = 0;

while (true) {
    $response = apiGet($baseUrl, $token, '/api/worker/jobs/next');
    $job = $response['job'] ?? null;

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

    $result = apiPostFile($baseUrl, $token, "/api/worker/jobs/{$episodeId}/complete", $outPath);
    echo "Uploaded episode {$episodeId}: " . json_encode($result) . "\n";

    @unlink($outPath);
    $processed++;
}

echo "Done. Processed {$processed} job(s).\n";
