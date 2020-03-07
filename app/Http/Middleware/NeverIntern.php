<?php

namespace App\Http\Middleware;

use Closure;
use App\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class NeverIntern
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
        if (Auth::user()->student->internship == null && sizeof(Auth::user()->student->finished_internships) == 0) {
            return $next($request);
        }

        throw new UnauthorizedException(403, 'User already is/was an intern.');
    }
}
