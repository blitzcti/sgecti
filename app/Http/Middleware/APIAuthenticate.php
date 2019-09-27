<?php

namespace App\Http\Middleware;

use App\Auth;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class APIAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Cookie::has(strtolower(config('app.name')) . '_session')) {
            Session::setId(Cookie::get(strtolower(config('app.name')) . '_session'));
        }

        Session::start();
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
