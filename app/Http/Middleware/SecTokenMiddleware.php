<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secToken = $request->header('X-SEC-TOKEN');

        try {
            Carbon::createFromFormat('Ymd', $secToken);

            if (strcmp($secToken, Carbon::now()->format('Ymd')) !== 0) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
