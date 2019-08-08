<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;
use App\Models\Color;
use App\Models\Coordinator;
use App\Models\Course;
use App\Models\CourseConfiguration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:course-list');
        $this->middleware('permission:course-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:course-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:course-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        $courses = Course::all();
        return view('admin.course.index')->with(['courses' => $courses]);
    }

    public function details($id)
    {
        $course = Course::findOrFail($id);

        $color = $course->color;
        $config = $course->configuration();
        $coordinator = $course->coordinator();

        return view('admin.course.details')->with(['course' => $course, 'config' => $config, 'coordinator' => $coordinator, 'color' => $color]);
    }

    public function create()
    {
        $colors = Color::all();
        $users = User::all();

        return view('admin.course.new')->with(['colors' => $colors, 'users' => $users]);
    }

    public function edit($id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('admin.curso.index');
        }

        $course = Course::findOrFail($id);
        $colors = Color::all();

        return view('admin.course.edit')->with(['course' => $course, 'colors' => $colors]);
    }

    public function store(StoreCourse $request)
    {
        $course = new Course();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo curso";
        $log .= "\nUsuário: " . Auth::user()->name;

        $course->created_at = Carbon::now();
        $course->name = $validatedData->name;
        $course->color_id = $validatedData->color;
        $course->active = $validatedData->active;

        $saved = $course->save();

        $config = new CourseConfiguration();

        $config->created_at = Carbon::now();
        $config->course_id = $course->id;
        $config->min_year = $validatedData->minYear;
        $config->min_semester = $validatedData->minSemester;
        $config->min_hours = $validatedData->minHour;
        $config->min_months = $validatedData->minMonth;
        $config->min_months_ctps = $validatedData->minMonthCTPS;
        $config->min_grade = $validatedData->minMark;

        $saved = $config->save();
        $log .= "\nNovos dados: " . json_encode($course, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar curso");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.curso.index')->with($params);
    }

    public function update($id, UpdateCourse $request)
    {
        $course = Course::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de curso";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($course, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $course->updated_at = Carbon::now();
        $course->name = $validatedData->name;
        $course->color_id = $validatedData->color;
        $course->active = $validatedData->active;

        $saved = $course->save();
        $log .= "\nNovos dados: " . json_encode($course, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar curso");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

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
