<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::user()->role->actions != $role) {
            return response([
                'error' => [
                'code' => 'INSUFFICIENT_ROLE',
                'description' => 'You are not authorized to access this resource.'
                ]
            ], 401);
        }

        return $next($request);
    }
}
