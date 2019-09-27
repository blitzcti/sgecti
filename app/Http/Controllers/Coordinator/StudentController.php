<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\StudentPDF;
use App\Models\Course;
use App\Models\Internship;
use App\Models\NSac\Student;
use App\Models\State;
use PDF;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:student-list');
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $students = Student::all()->filter(function ($student) use ($cIds) {
            return in_array($student->course_id, $cIds);
        });

        return view('coordinator.student.index')->with(['students' => $students]);
    }

    public function show($ra)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $student = Student::findOrFail($ra);
        if (!in_array($student->course_id, $cIds)) {
            abort(404);
        }

        return view('coordinator.student.details')->with(['student' => $student]);
    }

    public function pdf()
    {
        $courses = Auth::user()->coordinator_of;

        return view('coordinator.student.pdf')->with(['courses' => $courses]);
    }

    public function makePDF(StudentPDF $request)
    {
        ini_set('max_execution_time', 300);
        ini_set("memory_limit", "1G");

        $params = [];
        $validatedData = (object)$request->validated();

        $students = Student::actives()->sortBy('matricula');

        if (isset($validatedData->internships)) {
            $students2 = collect();

            $istates = $validatedData->internships;
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

                $students2 = $students2->merge($students->filter(function ($s) use ($is, $fis) {
                    return !in_array($s->matricula, $is) && !in_array($s->matricula, $fis);
                }));
            }

            $students = $students2->unique()->values()->sortBy('matricula');
            unset($students2);
        }

        $cIds = Auth::user()->coordinator_courses_id;
        $students = $students->filter(function ($s) use ($cIds) {
            return in_array($s->course_id, $cIds);
        })->sortBy('nome');

        if (isset($validatedData->courses)) {
            $courses = $validatedData->courses;
            $students = $students->filter(function ($student) use ($courses) {
                return in_array($student->course_id, $courses);
            });
        }

        if (isset($validatedData->periods)) {
            $periods = $validatedData->periods;
            $students = $students->filter(function ($student) use ($periods) {
                return in_array($student->turma_periodo, $periods);
            });
        }

        if (isset($validatedData->grades)) {
            $grades = $validatedData->grades;
            $students = $students->filter(function ($student) use ($grades) {
                return in_array($student->grade, $grades);
            });
        }

        if (isset($validatedData->classes)) {
            $classes = $validatedData->classes;
            $students = $students->filter(function ($student) use ($classes) {
                return in_array($student->class, $classes);
            });
        }

        $students_ra = array_column($students->toArray(), 'matricula');
        $internships = [];
        $finished_internships = [];
        $not_in_internships = [];
        $never_had_internship = [];

        $grades = $grades ?? [1, 2, 3, 4];
        $courses = Course::findOrFail($courses ?? $cIds);
        $classes = $classes ?? ['A', 'B', 'C', 'D'];
        $istates = $istates ?? [];
        if (sizeof($istates) == 0 || in_array(0, $istates)) {
            $internships = Internship::where('state_id', '=', State::OPEN)->where('active', '=', true)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
            $internships_ra = $internships->map(function ($i) {
                return $i->ra;
            })->toArray();
        }

        if (sizeof($istates) == 0 || in_array(1, $istates)) {
            $finished_internships = Internship::where('state_id', '=', State::FINISHED)->where('active', '=', true)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
            $finished_internships_ra = $finished_internships->map(function ($fi) {
                return $fi->ra;
            })->toArray();
        }

        if (sizeof($istates) == 0 || in_array(2, $istates)) {
            if (sizeof($internships) == 0) {
                $internships = Internship::where('state_id', '=', State::OPEN)->where('active', '=', true)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
                $internships_ra = $internships->map(function ($i) {
                    return $i->ra;
                })->toArray();
            }

            $not_in_internships = $students->filter(function ($s) use ($internships_ra) {
                return !in_array($s->matricula, $internships_ra);
            });
        }

        if (sizeof($istates) == 0 || in_array(3, $istates)) {
            if (sizeof($internships) == 0) {
                $internships = Internship::where('state_id', '=', State::OPEN)->where('active', '=', true)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
                $internships_ra = $internships->map(function ($i) {
                    return $i->ra;
                })->toArray();
            }

            if (sizeof($internships) == 0) {
                $finished_internships = Internship::where('state_id', '=', State::FINISHED)->where('active', '=', true)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
                $finished_internships_ra = $finished_internships->map(function ($fi) {
                    return $fi->ra;
                })->toArray();
            }

            $never_had_internship = $students->filter(function ($s) use ($internships_ra, $finished_internships_ra) {
                return !in_array($s->matricula, $internships_ra) && !in_array($s->matricula, $finished_internships_ra);
            });
        }

        $data = [
            'grades' => $grades,
            'courses' => $courses,
            'classes' => $classes,
            'internships' => $internships,
            'finished_internships' => $finished_internships,
            'not_in_internships' => $not_in_internships,
            'never_had_internship' => $never_had_internship,
        ];

        $pdf = PDF::loadView('pdf.students.report', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('alunos.pdf');
    }
}
