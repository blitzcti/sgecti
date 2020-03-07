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
        $courses = Auth::user()->coordinator_of;

        $students = Student::all()->filter(function (Student $student) use ($courses) {
            return $courses->contains($student->course);
        });

        return view('coordinator.student.index')->with(['students' => $students]);
    }

    public function show($ra)
    {
        $student = Student::findOrFail($ra);
        if (!Auth::user()->coordinator_of->contains($student->course)) {
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

        $students = Student::actives()->orderBy('matricula')->get();

        if (isset($validatedData->internships)) {
            $students2 = collect();

            $istates = $validatedData->internships;
            if (in_array(0, $istates)) { // Estagiando
                $students2 = $students2->merge(Internship::actives()->where('state_id', '=', State::OPEN)->orderBy('id')->get()
                    ->map(function (Internship $i) use ($students) {
                        return $students->find($i->ra);
                    }));
            }

            if (in_array(1, $istates)) { // Estágio finalizado
                $students2 = $students2->merge(Internship::actives()->where('state_id', '=', State::FINISHED)->orderBy('id')->get()
                    ->map(function (Internship $i) use ($students) {
                        return $students->find($i->ra);
                    }));
            }

            if (in_array(2, $istates)) { // Não estagiando
                $is = Internship::actives()->where('state_id', '=', State::OPEN)->orderBy('id')->get()
                    ->map(function (Internship $i) {
                        return $i->ra;
                    })->toArray();

                $students2 = $students2->merge($students->filter(function (Student $s) use ($is) {
                    return !in_array($s->matricula, $is);
                }));
            }

            if (in_array(3, $istates)) { // Nunca estagiaram
                $is = Internship::actives()->where('state_id', '=', State::OPEN)->orderBy('id')->get()
                    ->map(function (Internship $i) {
                        return $i->ra;
                    })->toArray();

                $fis = Internship::actives()->where('state_id', '=', State::FINISHED)->orderBy('id')->get()
                    ->map(function (Internship $i) {
                        return $i->ra;
                    })->toArray();

                $iis = Internship::actives()->where('state_id', '=', State::INVALID)->orderBy('id')->get()
                    ->map(function (Internship $i) {
                        return $i->ra;
                    })->toArray();

                $students2 = $students2->merge($students->filter(function (Student $s) use ($is, $fis, $iis) {
                    return !in_array($s->matricula, $is) && !in_array($s->matricula, $fis) && !in_array($s->matricula, $iis);
                }));
            }

            $students = $students2->unique()->values()->sortBy('matricula');
            unset($students2);
        }

        if (Auth::user()->isCoordinator()) {
            $courses = Auth::user()->coordinator_of;

            $students = $students->filter(function (Student $s) use ($courses) {
                return $courses->contains($s->course);
            })->sortBy('nome');
        }

        if (isset($validatedData->courses)) {
            $courses = $validatedData->courses;
            $students = $students->filter(function (Student $student) use ($courses) {
                return in_array($student->course_id, $courses);
            });
        }

        if (isset($validatedData->periods)) {
            $periods = $validatedData->periods;
            $students = $students->filter(function (Student $student) use ($periods) {
                return in_array($student->turma_periodo, $periods);
            });
        }

        if (isset($validatedData->grades)) {
            $grades = $validatedData->grades;
            $students = $students->filter(function (Student $student) use ($grades) {
                return in_array($student->grade, $grades);
            });
        }

        if (isset($validatedData->classes)) {
            $classes = $validatedData->classes;
            $students = $students->filter(function (Student $student) use ($classes) {
                return in_array($student->class, $classes);
            });
        }

        $students_ra = array_column($students->toArray(), 'matricula');
        $internships = [];
        $finished_internships = [];
        $not_in_internships = [];
        $never_had_internship = [];

        $grades = $grades ?? [1, 2, 3, 4];
        $courses = Course::findOrFail($courses ?? Auth::user()->coordinator_courses_id);
        $classes = $classes ?? ['A', 'B', 'C', 'D'];
        $istates = $istates ?? [];
        if (sizeof($istates) == 0 || in_array(0, $istates)) {
            $internships = Internship::actives()->where('state_id', '=', State::OPEN)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
            $internships_ra = $internships->map(function (Internship $i) {
                return $i->ra;
            })->toArray();
        }

        if (sizeof($istates) == 0 || in_array(1, $istates)) {
            $finished_internships = Internship::actives()->where('state_id', '=', State::FINISHED)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
            $finished_internships_ra = $finished_internships->map(function (Internship $fi) {
                return $fi->ra;
            })->toArray();
        }

        if (sizeof($istates) == 0 || in_array(2, $istates)) {
            if (sizeof($internships) == 0) {
                $internships = Internship::actives()->where('state_id', '=', State::OPEN)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
                $internships_ra = $internships->map(function (Internship $i) {
                    return $i->ra;
                })->toArray();
            }

            $not_in_internships = $students->filter(function (Student $s) use ($internships_ra) {
                return !in_array($s->matricula, $internships_ra);
            });
        }

        if (sizeof($istates) == 0 || in_array(3, $istates)) {
            if (sizeof($internships) == 0) {
                $internships = Internship::actives()->where('state_id', '=', State::OPEN)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
                $internships_ra = $internships->map(function (Internship $i) {
                    return $i->ra;
                })->toArray();
            }

            if (sizeof($internships) == 0) {
                $finished_internships = Internship::actives()->where('state_id', '=', State::FINISHED)->whereIn('ra', $students_ra)->get()->sortBy('student.nome');
                $finished_internships_ra = $finished_internships->map(function (Internship $fi) {
                    return $fi->ra;
                })->toArray();
            }

            $never_had_internship = $students->filter(function (Student $s) use ($internships_ra, $finished_internships_ra) {
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
