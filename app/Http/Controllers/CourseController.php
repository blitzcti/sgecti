<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseConfiguration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('course.index')->with(['courses' => $courses]);
    }

    public function new()
    {
        return view('course.new');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('curso.index');
        }

        $course = Course::findOrFail($id);
        $colors = [
            (object)['id' => 'red', 'name' => 'Vermelho'],
            (object)['id' => 'green', 'name' => 'Verde'],
            (object)['id' => 'aqua', 'name' => 'Aqua'],
            (object)['id' => 'purple', 'name' => 'Roxo'],
            (object)['id' => 'blue', 'name' => 'Azul'],
            (object)['id' => 'yellow', 'name' => 'Amarelo'],
            (object)['id' => 'black', 'name' => 'Preto']
        ];

        return view('course.edit')->with(['course' => $course, 'colors' => $colors]);
    }

    public function save(Request $request)
    {
        $course = new Course();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate(
                [
                    'name' => 'required|max:30',
                    'color' => 'required|max:6',
                    'active' => 'required'
                ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $course = Course::all()->find($id);

                $course->updated_at = Carbon::now();
            } else { // New
                $course->created_at = Carbon::now();

                $config = new CourseConfiguration();
                $configValidatedData = (object)$request->validate(
                    [
                        'minYear' => 'required',
                        'minSemester' => 'required',
                        'minHour' => 'required',
                        'minMonth' => 'required',
                        'minMonthCTPS' => 'required',
                        'minMark' => 'required'
                    ]
                );

                $config->min_year = $configValidatedData->minYear;
                $config->min_semester = $configValidatedData->minSemester;
                $config->min_hours = $configValidatedData->minHour;
                $config->min_months = $configValidatedData->minMonth;
                $config->min_months_ctps = $configValidatedData->minMonthCTPS;
                $config->min_grade = $configValidatedData->minMark;
            }

            $course->name = $validatedData->name;
            $course->color = $validatedData->color;
            $course->active = $validatedData->active == 'true';

            $saved = $course->save();

            if (isset($config)) {
                $config->id_course = $course->id;

                $saved = $config->save();
            }

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('curso.index')->with($params);
    }
}
