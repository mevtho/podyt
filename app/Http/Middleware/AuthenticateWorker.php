<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateWorker
{
    public function handle(Request $request, Closure $next)
    {
        $expected = config('services.worker.token');
        $token = $request->bearerToken();

        if (empty($expected) || empty($token) || !hash_equals($expected, $token)) {
            abort(401, 'Invalid worker token');
        }

        return $next($request);
    }
}
