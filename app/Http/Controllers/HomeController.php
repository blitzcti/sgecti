<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
            $cIds = Auth::user()->coordinator_courses_id;

            $data['strCourses'] = $strCourses;
            $data['requiringFinish'] = Internship::requiringFinish();
            $data['proposals'] = Proposal::all()->sortBy('id')->where('approved_at', '=', null)
                ->filter(function ($proposal) use ($cIds) {
                    $ret = false;
                    foreach ($proposal->courses as $course) {
                        if (!$ret) {
                            $ret = in_array($course->id, $cIds);
                        }
                    }

                    return $ret;
                });
        } else if ($user->isCompany()) {
            $company = Company::all()->where('email', '=', $user->email)->first();
            $data['proposals'] = Proposal::all()->where('company_id', '=', $company->id);
            $data['proposalsInProgress'] = Proposal::all()->where('company_id', '=', $company->id)->where('approved_at', '=', null);
        } else if ($user->isStudent()) {
            $data['proposals'] = Proposal::all()->sortBy('id')->where('approved_at', '<>', null);
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
