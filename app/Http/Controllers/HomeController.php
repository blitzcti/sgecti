<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $strCourses = '';
        if ($user->isCoordinator()) {
            $array = $user->coordinator_of->map(function ($c) {return $c->name; })->toArray();
            $last = array_slice($array, -1);
            $first = join(', ', array_slice($array, 0, -1));
            $both = array_filter(array_merge([$first], $last), 'strlen');
            $strCourses = join(' e ', $both);
        }

        return view('home')->with(['user' => $user, 'strCourses' => $strCourses]);
    }
}
