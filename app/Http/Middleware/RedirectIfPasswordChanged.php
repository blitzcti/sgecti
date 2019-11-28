<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfPasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->password_updated) {
            $params = http_build_query($request->except('password_updated'));
            if ($params != '') {
                $params = "?{$params}";
            }

            return redirect()->to(url()->current() . $params)->with('password_updated', true);
        }

        return $next($request);
    }
}
