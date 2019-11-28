<?php

namespace App\Http\Middleware;

use App\Auth;
use App\Broker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SSOAutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('broker.useSSO')) {
            $broker = new Broker;
            $response = $broker->getUserInfo();

            if (isset($response['error']) && strpos($response['error'], 'User cannot access this Broker.') !== false) {
                abort(403);
            }

            $reset = true;
            if (Cookie::has('__reset')) {
                $reset = false;
                Cookie::queue(Cookie::forget('__reset'));
            }

            // Reset the SSO Cookie if not authenticated.
            if (isset($response['error']) && strpos($response['error'], 'User not authenticated. Session ID:') !== false && $reset) {
                Cookie::queue(Cookie::make('__reset', true, 60));
                return $this->clearSSOCookie($request);
            }

            // If client is logged out in SSO server but still logged in broker.
            if (!isset($response['data']) && !Auth::guest()) {
                return $this->logout($request);
            }

            // If there is a problem with data in SSO server, we will re-attach client session.
            if (isset($response['error']) && strpos($response['error'], 'There is no saved session data associated with the broker session id') !== false) {
                return $this->clearSSOCookie($request);
            }

            // If client is logged in SSO server and didn't logged in broker...
            if (isset($response['data']) && (Auth::guest() || Auth::user()->id != $response['data']['id'])) {
                // ... we will authenticate our client.
                Auth::loginUsingId($response['data']['id']);
            }
        }

        return $next($request);
    }

    /**
     * Clearing SSO cookie so broker will re-attach SSO server session.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function clearSSOCookie(Request $request)
    {
        return redirect($request->fullUrl())->cookie(cookie('sso_token_' . config('broker.name')));
    }

    /**
     * Logging out authenticated user.
     * Need to make a page refresh because current page may be accessible only for authenticated users.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function logout(Request $request)
    {
        auth()->logout();
        return redirect($request->fullUrl());
    }
}
