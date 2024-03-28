<?php

// ProducerMiddleware.php
namespace App\Http\Middleware;

use Closure;

class ProducerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasRole('PRODUCER')) {
            abort(401, 'Unauthorized action, your not as Producer.');
        }

        return $next($request);
    }
}