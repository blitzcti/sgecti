<?php

namespace App\Http\Controllers\Auth;

use App\Broker;
use App\Http\Controllers\Controller;
use App\Models\NSac\Student;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (config('broker.useSSO')) {
            $broker = new Broker;

            return redirect($broker->serverLoginPage());
        } else {
            return view('auth.login');
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        if (config('broker.useSSO')) {
            $broker = new Broker;

            return $broker->login(
                $credentials[$this->username()], $credentials['password'], $request->filled('remember')
            );
        } else {
            if (!User::where('email', '=', $credentials[$this->username()])->exists() && Student::where('email2', '=', $credentials[$this->username()])->exists()) {
                $student = Student::where('email2', '=', $credentials[$this->username()])->first();

                $user = new User();
                $user->name = $student->nome;
                $user->phone = null;
                $user->email = $student->email2;
                $user->password = Hash::make($credentials['password']);
                $user->api_token = null;
                $user->assignRole('student');
                if ($user->save()) {
                    return $this->guard()->attempt(
                        $this->credentials($request), $request->filled('remember')
                    );
                }
            }

            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function logout(Request $request)
    {
        if (config('broker.useSSO')) {
            $broker = new Broker;

            $broker->logout();
            return redirect('/');
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
