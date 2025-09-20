<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized, hanya admin yang bisa akses.'
            ], 403);
        }

        return $next($request);
    }
}
