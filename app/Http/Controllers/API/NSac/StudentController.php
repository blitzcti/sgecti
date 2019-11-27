<?php

namespace App\Http\Controllers\API\NSac;

use App\APIUtils;
use App\Auth;
use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\NSac\Student;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:student-list');
    }

    public function get(Request $request)
    {
        if ((new Student())->isConnected()) {
            $students = Student::actives()->sortBy('matricula');

            if (is_array($request->istates)) {
                $students2 = collect();

                $istates = $request->istates;
                if (in_array(0, $istates)) { // Estagiando
                    $students2 = $students2->merge(Internship::where('state_id', '=', State::OPEN)->where('active', '=', true)->orderBy('id')->get()->map(function ($i) use ($students) {
                        return $students->find($i->ra);
                    }));
                }

                if (in_array(1, $istates)) { // Estágio finalizado
                    $students2 = $students2->merge(Internship::where('state_id', '=', State::FINISHED)->where('active', '=', true)->orderBy('id')->get()->map(function ($i) use ($students) {
                        return $students->find($i->ra);
                    }));
                }

                if (in_array(2, $istates)) { // Não estagiando
                    $is = Internship::where('state_id', '=', State::OPEN)->where('active', '=', true)->orderBy('id')->get()->map(function ($i) {
                        return $i->ra;
                    })->toArray();

                    $students2 = $students2->merge($students->filter(function ($s) use ($is) {
                        return !in_array($s->matricula, $is);
                    }));
                }

                if (in_array(3, $istates)) { // Nunca estagiaram
                    $is = Internship::where('state_id', '=', State::OPEN)->where('active', '=', true)->orderBy('id')->get()->map(function ($i) {
                        return $i->ra;
                    })->toArray();

                    $fis = Internship::where('state_id', '=', State::FINISHED)->where('active', '=', true)->orderBy('id')->get()->map(function ($i) {
                        return $i->ra;
                    })->toArray();

                    $iis = Internship::where('state_id', '=', State::INVALID)->where('active', '=', true)->orderBy('id')->get()->map(function ($i) {
                        return $i->ra;
                    })->toArray();

                    $students2 = $students2->merge($students->filter(function ($s) use ($is, $fis, $iis) {
                        return !in_array($s->matricula, $is) && !in_array($s->matricula, $fis) && !in_array($s->matricula, $iis);
                    }));
                }

                $students = $students2->unique()->values()->sortBy('matricula');
                unset($students2);
            }

            if (is_array($request->courses)) {
                $courses = $request->courses;
                $students = $students->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                });
            }

            if (is_array($request->periods)) {
                $periods = $request->periods;
                $students = $students->filter(function ($student) use ($periods) {
                    return in_array($student->turma_periodo, $periods);
                });
            }

            if (is_array($request->grades)) {
                $grades = $request->grades;
                $students = $students->filter(function ($student) use ($grades) {
                    return in_array($student->grade, $grades);
                });
            }

            if (is_array($request->classes)) {
                $classes = $request->classes;
                //dd($classes);
                $students = $students->filter(function ($student) use ($classes) {
                    return in_array($student->class, $classes);
                });
            }

            if (!is_array($students)) {
                $students = array_values($students->toArray());
            }

            if (!empty($request->q)) {
                $students = APIUtils::search($students, $request->q, 'nome');
            }
        } else {
            $students = null;
        }

        return response()->json(
            $students,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByCourse($course, Request $request)
    {
        if ((new Student())->isConnected()) {
            $students = Student::actives()->where('course_id', '=', $course)->sortBy('matricula');

            if (!is_array($students)) {
                $students = array_values($students->toArray());
            }

            if (!empty($request->q)) {
                $students = APIUtils::search($students, $request->q, 'nome');
            }
        } else {
            $students = null;
        }

        return response()->json(
            $students,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByRA($ra)
    {
        if ((new Student())->isConnected()) {
            $student = Student::findOrFail($ra);
        } else {
            $student = null;
        }

        $student->append(['internship_state', 'job_state', 'completed_hours', 'completed_months', 'ctps_completed_months', 'course_configuration']);

        return response()->json(
            $student,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByYear($year, Request $request)
    {
        if ((new Student())->isConnected()) {
            $students = Student::actives()->where('year', '=', $year)->sortBy('matricula');

            if (is_array($request->courses)) {
                $courses = $request->courses;
                $students = $students->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                });
            }

            if (!is_array($students)) {
                $students = array_values($students->toArray());
            }
        } else {
            $students = null;
        }

        return response()->json(
            $students,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByClass($class, Request $request)
    {
        if ((new Student())->isConnected()) {
            $year = Carbon::now()->year;
            if (!empty($request->year) && ctype_digit($request->year)) {
                $year = $request->year;
            }

            $students = Student::actives()->where('turma', '=', $class)->where('turma_ano', '=', $year);

            if (is_array($request->get('courses'))) {
                $courses = $request->get('courses');
                $students = $students->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                });
            }

            if (!is_array($students)) {
                $students = array_values($students->toArray());
            }
        } else {
            $students = null;
        }

        return response()->json(
            $students,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getPhoto($ra, Request $request)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $student = Student::findOrFail($ra);
        if (!in_array($student->course->id, $cIds)) {
            abort(404);
        }

        if (!Storage::disk('local')->exists("students/$student->matricula.jpg")) {
            abort(404);
        }

        if ($request->has('w') && $request->has('h') && ctype_digit($request->get('w')) && ctype_digit($request->get('h'))) {
            $w = $request->get('w');
            $h = $request->get('h');
            Image::make(storage_path("app/students/$student->matricula.jpg"))->resize($w, $h)->save(storage_path("app/students/img.jpg"));
            return response()->file(storage_path("app/students/img.jpg"));
        } else {
            return response()->file(storage_path("app/students/$student->matricula.jpg"));
        }
    }
}
