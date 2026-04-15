<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class Authorization
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('token') ?? $request->query('token');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'token not provided'
            ], 400);
        }
        $user = User::where('token', $token)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'invalid token'
            ], 401);
        }
        $request->user = $user;
        return $next($request);
    }
}
