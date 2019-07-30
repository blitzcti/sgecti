<?php

namespace App\Http\Controllers;

use App\Models\NSac\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
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
        $student = Student::findOrFail($ra);
        return view('coordinator.student.details')->with(['student' => $student]);
    }
}
