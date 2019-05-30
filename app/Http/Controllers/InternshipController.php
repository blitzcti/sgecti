<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::all();
        return view('coordinator.internship.index')->with(['internships' => $internships]);
    }

    public function new()
    {
        $companies = Company::all()->where('ativo', '=', true);
        return view('coordinator.internship.new')->with(['companies' => $companies]);
    }
}
