<?php

namespace App\Http\Controllers\API\NSac;

use App\Http\Controllers\Controller;
use App\Models\NSac\Student;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:student-list');
    }

    /**
     * Search for a string in a specific array column
     *
     * @param array $array
     * @param string $q
     * @param null|string $col
     *
     * @return array
     */
    function search($array, $q, $col = null)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            if ($col == null) {
                return (strpos(strtoupper($v), strtoupper($q)) !== false);
            } else {
                return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
            }
        }, ARRAY_FILTER_USE_BOTH);
        $array = array_values($array);
        return $array;
    }

    public function get(Request $request)
    {
        if ((new Student())->isConnected()) {
            $students = Student::actives()->sortBy('matricula');

            if (is_array($request->istates)) {
                $students = collect();

                $istates = $request->istates;
                if (in_array(0, $istates)) {
                    $students = $students->merge(State::findOrFail(1)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                        return Student::findOrFail($i->ra);
                    }));
                }

                if (in_array(1, $istates)) {
                    $students = $students->merge(State::findOrFail(2)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                        return Student::findOrFail($i->ra);
                    }));
                }

                if (in_array(2, $istates)) {
                    $students = Student::actives()->sortBy('matricula');
                    $is = State::findOrFail(1)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                        return $i->ra;
                    })->toArray();

                    $fis = State::findOrFail(2)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                        return $i->ra;
                    })->toArray();

                    $students = $students->filter(function ($s) use ($is, $fis) {
                        return !in_array($s->matricula, $is) && !in_array($s->matricula, $fis);
                    });
                }

                $students = $students->sortBy('matricula');
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
            $students = Student::actives()->where('course_id', '=', $course)->sortBy('matricula');
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
            $students = Student::actives()->where('year', '=', $year)->sortBy('matricula');

            if (is_array($request->courses)) {
                $courses = $request->courses;
                $students = $students->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                });
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

            $students = Student::actives()->where('turma', '=', $class)->where('turma_ano', '=', $year);

            if (is_array($request->get('courses'))) {
                $courses = $request->get('courses');
                $students = $students->filter(function ($student) use ($courses) {
                    return in_array($student->course_id, $courses);
                });
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
