<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.index');
    }

    public function new()
    {
        return view('course.new');
    }

    public function edit()
    {
        return view('course.edit')->with(['course' => null]);
    }

    public function save(Request $request)
    {
        $course = new Course();
        if ($request->exists('name')) {
            $course->name = $request->input('name');
            $course->color = $request->input('color');
            $course->active = $request->input('active') == 'true';

            return view('course.index')->with(['saved' => $course->save()]);
        }

        return view('course.index')->with(['saved' => false]);
    }
}
