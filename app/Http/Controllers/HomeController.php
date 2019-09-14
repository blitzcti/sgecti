<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Proposal;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function frontPage()
    {
        return view('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $data = ['user' => $user];

        if ($user->isCoordinator()) {
            $strCourses = $user->coordinator_courses_name;
            $data['strCourses'] = $strCourses;
            $data['requiringFinish'] = Internship::requiringFinish();
            $data['proposals'] = Proposal::all()->sortBy('id');
        }

        return view('home')->with($data);
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        return view('user.notifications')->with(['notifications' => $notifications]);
    }
}
