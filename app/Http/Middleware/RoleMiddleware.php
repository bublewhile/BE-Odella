<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin') or ->middleware('role:admin,kurir')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user() ?? auth('api')->user();

        if (!$user || !in_array($user->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Anda tidak memiliki hak akses.',
                ], 403);
            }

            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}
