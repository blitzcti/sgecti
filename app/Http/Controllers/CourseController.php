<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Course;
use App\Models\CourseConfiguration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:course-list');
        $this->middleware('permission:course-create', ['only' => ['new', 'save']]);
        $this->middleware('permission:course-edit', ['only' => ['edit', 'save']]);
        $this->middleware('permission:course-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        $courses = Course::all();
        return view('admin.course.index')->with(['courses' => $courses]);
    }

    public function details($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('admin.curso.index');
        }

        $course = Course::findOrFail($id);

        $color = $course->color();
        $config = $course->configuration();
        $coordinator = $course->coordinator();

        return view('admin.course.details')->with(['course' => $course, 'config' => $config, 'coordinator' => $coordinator, 'color' => $color]);
    }

    public function new()
    {
        $colors = Color::all();
        return view('admin.course.new')->with(['colors' => $colors]);
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('admin.curso.index');
        }

        $course = Course::findOrFail($id);
        $colors = Color::all();

        return view('admin.course.edit')->with(['course' => $course, 'colors' => $colors]);
    }

    public function save(Request $request)
    {
        $course = new Course();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'name' => 'required|max:30',
                'color' => 'required|numeric|min:1',
                'active' => 'required|boolean'
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $course = Course::all()->find($id);

                $course->updated_at = Carbon::now();
                Log::info("Alteração");
                Log::info("Dados antigos: " . json_encode($course, JSON_UNESCAPED_UNICODE));
            } else { // New
                $course->created_at = Carbon::now();

                $config = new CourseConfiguration();
                $configValidatedData = (object)$request->validate([
                    'minYear' => 'required|numeric|min:1|max:3',
                    'minSemester' => 'required|numeric|min:1|max:2',
                    'minHour' => 'required|numeric|min:1',
                    'minMonth' => 'required|numeric|min:1',
                    'minMonthCTPS' => 'required|numeric|min:1',
                    'minMark' => 'required|numeric|min:0|max:10'
                ]);

                $config->min_year = $configValidatedData->minYear;
                $config->min_semester = $configValidatedData->minSemester;
                $config->min_hours = $configValidatedData->minHour;
                $config->min_months = $configValidatedData->minMonth;
                $config->min_months_ctps = $configValidatedData->minMonthCTPS;
                $config->min_grade = $configValidatedData->minMark;
            }

            $course->name = $validatedData->name;
            $course->id_color = $validatedData->color;
            $course->active = $validatedData->active;

            $saved = $course->save();

            if (isset($config)) {
                $config->id_course = $course->id;

                $saved = $config->save();
            }

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.curso.index')->with($params);
    }

    public function delete(Request $request)
    {
        $params = [];
        $saved = false;

        if ($request->exists('id')) {
            $id = $request->input('id');
            $course = Course::findOrFail($id);
            $saved = $course->delete();
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';
        return redirect()->route('admin.curso.index')->with($params);
    }
}
