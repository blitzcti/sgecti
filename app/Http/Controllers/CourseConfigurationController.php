<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseConfiguration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseConfigurationController extends Controller
{
    public function index($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('curso.index');
        }

        $course = Course::findOrFail($id);
        $configurations = CourseConfiguration::all()->where('id_course', '=', $course->id)->sortByDesc('id');

        return view('course.configuration.index')->with(['course' => $course, 'configurations' => $configurations]);
    }

    public function new($id)
    {
        $course = Course::findOrFail($id);
        return view('course.configuration.new')->with(['course' => $course]);
    }

    public function edit($id, $id_config)
    {
        if (!is_numeric($id_config)) {
            return redirect()->route('curso.configuracao.index');
        }

        $course = Course::findOrFail($id);
        $config = CourseConfiguration::findOrFail($id_config);

        return view('course.configuration.edit')->with(['config' => $config, 'course' => $course]);
    }

    public function save(Request $request, $id)
    {
        $config = new CourseConfiguration();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate(
                [
                    'minYear' => 'required',
                    'minSemester' => 'required',
                    'minHour' => 'required',
                    'minMonth' => 'required',
                    'minMonthCTPS' => 'required',
                    'minMark' => 'required'
                ]
            );

            $config->id_course = $id;

            if ($request->exists('id_config')) { // Edit
                $id_config = $request->input('id_config');
                $config = CourseConfiguration::all()->find($id_config);

                $config->updated_at = Carbon::now();
            } else { // New
                $config->created_at = Carbon::now();
            }

            $config->min_year = $validatedData->minYear;
            $config->min_semester = $validatedData->minSemester;
            $config->min_hours = $validatedData->minHour;
            $config->min_months = $validatedData->minMonth;
            $config->min_months_ctps = $validatedData->minMonthCTPS;
            $config->min_grade = $validatedData->minMark;

            $saved = $config->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('curso.configuracao.index', $id)->with($params);
    }
}
