<?php

namespace App\Http\Controllers\Auth;

use App\Broker;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        if (config('broker.useSSO')) {
            $broker = new Broker;

            $credentials = $this->credentials($request);

            return $broker->login(
                $credentials[$this->username()], $credentials['password'], $request->filled('remember')
            );
        } else {
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
    }

    protected function logout(Request $request)
    {
        if (config('broker.useSSO')) {
            $broker = new Broker;

            $broker->logout();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
