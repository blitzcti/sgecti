<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\NSac\Student;
use \PDF;

class ReportController extends Controller
{
    public function index()
    {
        ini_set('max_execution_time', 300);

        $courses = Course::all()->sortBy('id');
        if ((new Student())->isConnected()) {
            $student = Student::where('matricula', 'LIKE', '17%')->get()->sortBy('matricula');
        } else {
            $student = [];
        }

        $data = [
            'courses' => $courses,
            'students' => $student,
        ];

        $pdf = PDF::loadView('pdf.index', $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('index.pdf');
    }
}
