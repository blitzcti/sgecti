<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseConfiguration;

class CourseConfigurationController extends Controller
{
    public function index($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('curso.index');
        }

        $course = Course::findOrFail($id);
        $configurations = CourseConfiguration::all()->where('id_course', '=', $course->id);

        return view('course.configuration.index')->with(['course' => $course, 'configurations' => $configurations]);
    }
}
