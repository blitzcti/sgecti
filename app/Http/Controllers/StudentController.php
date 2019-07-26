<?php

namespace App\Http\Controllers;

use App\Models\NSac\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('coordinator.student.index')->with(['students' => $students]);
    }

    public function details($ra)
    {
        $student = Student::findOrFail($ra);
        $internship = $student->internship;
        $finishedInternship = $student->finishedInternship;
        return view('coordinator.student.details')->with(['student' => $student, 'internship' => $internship, 'finishedInternship' => $finishedInternship]);
    }
}
