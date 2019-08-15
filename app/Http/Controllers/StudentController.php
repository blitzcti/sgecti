<?php

namespace App\Http\Controllers;

use App\Models\NSac\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:student-list');
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $students = Student::all()->filter(function ($student) use ($cIds) {
            return in_array($student->course_id, $cIds);
        });

        return view('coordinator.student.index')->with(['students' => $students]);
    }

    public function details($ra)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $student = Student::findOrFail($ra);
        if (!in_array($student->course_id, $cIds)) {
            abort(404);
        }

        return view('coordinator.student.details')->with(['student' => $student]);
    }
}
