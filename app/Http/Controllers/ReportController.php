<?php

namespace App\Http\Controllers;

use App\Models\Course;
use \PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = [
            'courses' => Course::all()->sortBy('id')
        ];
        $pdf = PDF::loadView('pdf.index', $data);
        //return view('pdf.index')->with($data);
        return $pdf->stream('index.pdf');
    }
}
