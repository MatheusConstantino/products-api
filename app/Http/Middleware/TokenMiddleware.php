<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;


class TokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Token missmatch'], 401);
        }

        return $next($request);
    }
}
