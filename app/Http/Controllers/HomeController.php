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
            $strCourses = $user->coordinator_courses_name;
        }

        return view('home')->with(['user' => $user, 'strCourses' => $strCourses]);
    }
}
