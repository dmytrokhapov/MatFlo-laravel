<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Api_key;
use App\Models\Api_log;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $apiKey = $request->header('MATFLO-API-KEY');
        $api = Api_key::where('api_key', $apiKey)->first();

        if($api) {
            if($role === "USER" || $api->keyuser->role === $role) {
                $request->merge(["keyuser" => $api->keyuser]);
                $clientIpAddress = $request->ip();
                Api_log::create([
                    'ip_address' => $clientIpAddress,
                    'api_key_id' => $api->id,
                    'api' => $request->url()
                ]);
                return $next($request);
            } else {
                return response()->json(['error' => 'Unallowed permission'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid API Key'], 403);
        }
    }
}
