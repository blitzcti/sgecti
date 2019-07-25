<?php

namespace App\Http\Controllers;

use App\Models\BimestralReport;
use App\Models\Course;
use App\Models\Internship;
use App\Models\NSac\Student;
use App\Models\State;
use Illuminate\Support\Facades\Request;
use \PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('coordinator.report.index');
    }

    public function bimestral()
    {
        $internships = State::findOrFail(1)->internships()->get();
        return view('coordinator.report.bimestral')->with(['internships' => $internships]);
    }

    public function final()
    {
        return view('coordinator.report.final');
    }

    public function storeBimestral(Request $request)
    {
        $bimstreal = new BimestralReport();
        $params = [];


    }

    public function storeFinal(Request $request)
    {

    }

    public function makePDF()
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
