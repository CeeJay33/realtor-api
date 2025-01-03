<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifySessionHeader
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Session is invalid'], 401);
        }

        return $next($request);
    }
}
