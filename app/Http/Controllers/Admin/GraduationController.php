<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Internship;
use App\Models\NSac\Student;
use Illuminate\Http\Request;

class GraduationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:graduation-list');
    }

    public function index()
    {
        $students = Student::actives()->filter(function (Student $s) {
            return $s->canGraduate();
        });

        return view('admin.graduation.index')->with(['students' => $students]);
    }

    public function graduate($ra, Request $request)
    {
        dd("Anderson, gradua o menino de RA = {$ra}", 'Agora é com vc meu querido');
    }
}
