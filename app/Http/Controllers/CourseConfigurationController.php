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
            return redirect()->route('admin.curso.index');
        }

        $course = Course::findOrFail($id);
        $configurations = CourseConfiguration::all()->where('id_course', '=', $course->id)->sortByDesc('id');

        return view('admin.course.configuration.index')->with(['course' => $course, 'configurations' => $configurations]);
    }

    public function new($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course.configuration.new')->with(['course' => $course]);
    }

    public function edit($id, $id_config)
    {
        if (!is_numeric($id_config)) {
            return redirect()->route('admin.curso.configuracao.index');
        }

        $course = Course::findOrFail($id);
        $config = CourseConfiguration::findOrFail($id_config);

        return view('admin.course.configuration.edit')->with(['config' => $config, 'course' => $course]);
    }

    public function save(Request $request, $id)
    {
        $config = new CourseConfiguration();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate(
                [
                    'minYear' => 'required|numeric|min:1|max:3',
                    'minSemester' => 'required|numeric|min:1|max:2',
                    'minHour' => 'required|numeric|min:1',
                    'minMonth' => 'required|numeric|min:1',
                    'minMonthCTPS' => 'required|numeric|min:1',
                    'minMark' => 'required|numeric|min:0|max:10'
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

        return redirect()->route('admin.curso.configuracao.index', $id)->with($params);
    }
}
