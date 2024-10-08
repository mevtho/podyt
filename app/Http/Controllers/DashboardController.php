<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->feeds()->count() === 1) {
            return redirect()->to(route('feed.show', ['feed' => $request->user()->feeds()->first()]));
        } else {
            return redirect()->to(route('feed.index'));
        }
    }
}
