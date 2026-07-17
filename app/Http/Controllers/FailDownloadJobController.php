<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Workflow\WorkflowStub;

class FailDownloadJobController extends Controller
{
    public function __invoke(Request $request, Episode $episode)
    {
        abort_unless($episode->status === 'queued_remote', 409, 'Episode is not awaiting a remote download.');

        $data = $request->validate([
            'error' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($episode->workflow_id) {
            WorkflowStub::load($episode->workflow_id)->remoteDownloadFailed($data['error'] ?? 'Unknown error');
        }

        return response()->json(['status' => 'ok']);
    }
}
