<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil user dari request
        $user = $request->user();

        // Jika tidak ada user (tidak terautentikasi)
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Jika user.role cocok salah satu dari roles
        if (!empty($roles) && !in_array($user->role, $roles)) {
            return response()->json(['message' => 'Forbidden - role mismatch'], 403);
        }

        return $next($request);
    }
}
