<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentPDF;
use App\Models\NSac\Student;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
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

    public function details($ra)
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
        $params = [];
        $validatedData = (object)$request->validated();

        $students = Student::actives()->sortBy('matricula');

        if (isset($validatedData->internships)) {
            $students2 = collect();

            $istates = $validatedData->internships;
            if (in_array(0, $istates)) { // Estagiando
                $students2 = $students2->merge(State::findOrFail(1)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) use ($students) {
                    return $students->find($i->ra);
                }));
            }

            if (in_array(1, $istates)) { // Estágio finalizado
                $students2 = $students2->merge(State::findOrFail(2)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) use ($students) {
                    return $students->find($i->ra);
                }));
            }

            if (in_array(2, $istates)) { // Não estagiando
                $is = State::findOrFail(1)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                    return $i->ra;
                })->toArray();

                $students2 = $students2->merge($students->filter(function ($s) use ($is) {
                    return !in_array($s->matricula, $is);
                }));
            }

            if (in_array(3, $istates)) { // Nunca estagiaram
                $is = State::findOrFail(1)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                    return $i->ra;
                })->toArray();

                $fis = State::findOrFail(2)->internships->where('active', '=', true)->sortBy('id')->map(function ($i) {
                    return $i->ra;
                })->toArray();

                $students2 = $students2->merge($students->filter(function ($s) use ($is, $fis) {
                    return !in_array($s->matricula, $is) && !in_array($s->matricula, $fis);
                }));
            }

            $students = $students2->unique()->values()->sortBy('matricula');
            unset($students2);
        }

        if (Auth::user()->isCoordinator()) {
            $cIds = Auth::user()->coordinator_courses_id;
            $students = $students->filter(function ($s) use ($cIds) {
                return in_array($s->course_id, $cIds);
            })->sortBy('matricula');
        }

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

        $data = [
            'students' => $students,
        ];

        $pdf = PDF::loadView('pdf.students.report', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('alunos.pdf');
    }
}
