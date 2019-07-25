<?php

namespace App\Http\Controllers;

use App\Models\NSac\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('coordinator.student.index');
    }

    public function details($ra)
    {
        $student = Student::findOrFail($ra);
        $internship = $student->internship;
        return view('coordinator.student.details')->with(['student' => $student, 'internship' => $internship]);
    }
}
