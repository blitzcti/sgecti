<?php

namespace App\Http\Middleware;

use Closure;
use App\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isAdmin()) {
            return $next($request);
        }

        throw new UnauthorizedException(403, 'User is not an admin.');
    }
}
