<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Route;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $permission = Route::currentRouteName();
    
        if (!JWTAuth::user()->hasPermissionTo($permission)) {
            return response()->json(['status' => 'Access denied'], 403);
        }

        return $next($request);
    }
}