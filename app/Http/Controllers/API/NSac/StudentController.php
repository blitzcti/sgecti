<?php

namespace App\Http\Controllers\API\NSac;

use App\Http\Controllers\Controller;
use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator', ['only' => ['getPhoto']]);
    }

    /**
     * Search for a string in a specific array column
     *
     * @param $array array
     * @param $q string
     * @param $col string
     *
     * @return array
     */
    function search($array, $q, $col)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
        }, ARRAY_FILTER_USE_BOTH);
        $array = array_values($array);
        return $array;
    }

    public function get(Request $request)
    {
        if ((new Student())->isConnected()) {
            $students = Student::all()->sortBy('matricula');

            if (is_array($request->get('courses'))) {
                $courses = $request->get('courses');
                $students = $students->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                });
            }

            if (is_array($request->get('periods'))) {
                $periods = $request->get('periods');
                $students = $students->filter(function ($student) use ($periods) {
                    return in_array($student->turma_periodo, $periods);
                });
            }

            if (is_array($request->get('grades'))) {
                $grades = $request->get('grades');
                $students = $students->filter(function ($student) use ($grades) {
                    return in_array($student->grade, $grades);
                });
            }

            if (is_array($request->get('istates'))) {
                $istates = $request->get('istates');
                $students = $students->filter(function ($student) use ($istates) {
                    return in_array($student->internship_state, $istates);
                });
            }

            $students = array_values($students->toArray());

            if (!empty($request->q)) {
                $students = $this->search($students, $request->q, 'nome');
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
            $students = Student::all()->where('course_id', '=', $course)->sortBy('matricula');
            $students = array_values($students->toArray());

            if (!empty($request->q)) {
                $students = $this->search($students, $request->q, 'nome');
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

        return response()->json(
            [$student],
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
            $year = substr($year, 2, 2);

            if (is_array($request->get('courses'))) {
                $courses = $request->get('courses');
                $students = Student::where('matricula', 'LIKE', "$year%")->get()->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                })->sortBy('matricula');
            } else {
                $students = Student::where('matricula', 'LIKE', "$year%")->get()->sortBy('matricula');
            }

            $students = array_values($students->toArray());
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

            if (is_array($request->get('courses'))) {
                $courses = $request->get('courses');
                $students = Student::where('turma', '=', $class)->where('turma_ano', '=', $year)->get()->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                })->sortBy('matricula');
            } else {
                $students = Student::where('turma', '=', $class)->where('turma_ano', '=', $year)->get();
            }

            $students = array_values($students->toArray());
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
