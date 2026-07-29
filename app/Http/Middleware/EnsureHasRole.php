<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roleUserAuth = $request->user()->role->name;
        if ($roleUserAuth === $role) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No tienes permisos para realizar esta acción'
        ], 403);
    }
}
