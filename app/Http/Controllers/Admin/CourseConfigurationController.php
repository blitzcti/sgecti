<?php

namespace App\Http\Controllers\Admin;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyCourseConfiguration;
use App\Http\Requests\Admin\StoreCourseConfiguration;
use App\Http\Requests\Admin\UpdateCourseConfiguration;
use App\Models\Course;
use App\Models\CourseConfiguration;
use Illuminate\Support\Facades\Log;

class CourseConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:courseConfiguration-list');
        $this->middleware('permission:courseConfiguration-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:courseConfiguration-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:course-delete', ['only' => ['destroy']]);
    }

    public function index(int $id)
    {
        $course = Course::findOrFail($id);
        $configurations = $course->configurations->sortByDesc('id');

        return view('admin.course.configuration.index')->with(['course' => $course, 'configurations' => $configurations]);
    }

    public function create($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course.configuration.new')->with(['course' => $course]);
    }

    public function edit($id, $id_config)
    {
        $course = Course::findOrFail($id);
        $config = CourseConfiguration::findOrFail($id_config);

        return view('admin.course.configuration.edit')->with(['config' => $config, 'course' => $course]);
    }

    public function store($courseId, StoreCourseConfiguration $request)
    {
        $config = new CourseConfiguration();
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Nova configuração de curso";
        $log .= "\nUsuário: {$user->name}";

        $config->course_id = $courseId;
        $config->min_year = $validatedData->minYear;
        $config->min_semester = $validatedData->minSemester;
        $config->min_hours = $validatedData->minHour;
        $config->min_months = $validatedData->minMonth;
        $config->min_months_ctps = $validatedData->minMonthCTPS;
        $config->min_grade = $validatedData->minGrade;

        $saved = $config->save();
        $log .= "\nNovos dados: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração de curso");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.curso.configuracao.index', $courseId)->with($params);
    }

    public function update($courseId, $id, UpdateCourseConfiguration $request)
    {
        $config = CourseConfiguration::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Alteração de configuração de curso";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $config->course_id = $courseId;
        $config->min_year = $validatedData->minYear;
        $config->min_semester = $validatedData->minSemester;
        $config->min_hours = $validatedData->minHour;
        $config->min_months = $validatedData->minMonth;
        $config->min_months_ctps = $validatedData->minMonthCTPS;
        $config->min_grade = $validatedData->minGrade;

        $saved = $config->save();
        $log .= "\nNovos dados: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração de curso");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.curso.configuracao.index', ['id' => $courseId])->with($params);
    }

    public function destroy($courseId, $id, DestroyCourseConfiguration $request)
    {
        $config = CourseConfiguration::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Exclusão de configuração de curso";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $config->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir configuração de curso");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';
        return redirect()->route('admin.curso.configuracao.index', ['id' => $courseId])->with($params);
    }
}
