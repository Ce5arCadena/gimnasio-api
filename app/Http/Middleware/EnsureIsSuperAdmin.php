<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roleUserAuth = $request->user()->role->name;
        if ($roleUserAuth === config('gym.rol_super_admin')) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No tienes permisos para realizar esta acción'
        ], 403);
    }
}
