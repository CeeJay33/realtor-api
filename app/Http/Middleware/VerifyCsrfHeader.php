<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VerifyCsrfHeader
{
    public function handle($request, Closure $next)
    {
        // Retrieve the CSRF token from the cookie
        $csrfTokenFromCookie = $request->cookie('XSRF-TOKEN');
        // Retrieve the CSRF token stored in the session
        $csrfTokenFromSession = Session::token();

        // Compare the tokens
        if (!$csrfTokenFromCookie || $csrfTokenFromSession !== urldecode($csrfTokenFromCookie)) {
            // Tokens do not match, return a 419 response
            return response()->json(['message' => 'CSRF token mismatch'], 419);
        }

        // Tokens match, proceed with the request
        return $next($request);
    }
}
