<?php

// VerifierMiddleware.php
namespace App\Http\Middleware;

use Closure;

class VerifierMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasRole('VERIFIER')) {
            abort(401, 'Unauthorized action, your not as Verifier');
        }

        return $next($request);
    }
}