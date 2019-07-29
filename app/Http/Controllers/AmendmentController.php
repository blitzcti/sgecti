<?php

namespace App\Http\Controllers;

use App\Models\Amendment;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmendmentController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:internshipAmendment-list');
        $this->middleware('permission:internshipAmendment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:internshipAmendment-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $amendments = Amendment::all()->filter(function ($amendment) use ($cIds) {
            return in_array($amendment->internship->student->course_id, $cIds);
        });

        return view('coordinator.internship.amendment.index')->with(['amendments' => $amendments]);
    }

    public function indexByInternship($id)
    {
        $internship = Internship::findOrFail($id);
        $amendments = $internship->amendments;

        return view('coordinator.internship.amendment.index')->with(['amendments' => $amendments, 'internship' => $internship]);
    }
}
