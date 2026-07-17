<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Workflow\WorkflowStub;

class CompleteDownloadJobController extends Controller
{
    public function __invoke(Request $request, Episode $episode)
    {
        abort_unless($episode->status === 'queued_remote', 409, 'Episode is not awaiting a remote download.');

        $request->validate([
            'file' => ['required', 'file', 'mimes:mp3'],
        ]);

        $fileName = $episode->uuid . '.mp3';

        Storage::disk('download')->putFileAs('', $request->file('file'), $fileName);

        $episode->update([
            'status' => 'downloaded',
            'mp3_location_type' => 'path',
            'mp3_location' => $fileName,
            'delete_download_at' => now()->addDays(7),
            'claimed_at' => null,
        ]);

        if ($episode->workflow_id) {
            WorkflowStub::load($episode->workflow_id)->remoteDownloadSucceeded();
        }

        return response()->json(['status' => 'ok']);
    }
}
