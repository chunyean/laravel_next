<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class RequestTiming
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $time = (microtime(true) - $start) * 1000;

        Log::info('REQUEST TIMING', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'time_ms' => $time,
        ]);

        return $response;
    }
}
