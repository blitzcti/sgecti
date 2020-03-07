<?php

namespace App\Http\Controllers\Admin;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendMail;
use App\Mail\FreeMail;
use App\Models\Course;
use App\Models\Internship;
use App\Models\NSac\Student;
use App\Models\State;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $courses = Course::getActives();
        $students = Student::getActives();

        return view('admin.message.index')->with(['courses' => $courses, 'students' => $students]);
    }

    public function sendFreeMail($subject, $messageBody, Student $student)
    {
        return Mail::to($student->email2)->send(new FreeMail($subject, $messageBody));
    }

    public function sendEmail(SendMail $request)
    {
        $params = [];
        $validatedData = (object)$request->validated();

        if (config('app.debug')) {
            $student = Student::find(1757037);

            $this->sendFreeMail($validatedData->subject, $validatedData->messageBody, $student);
        } else {
            if ($validatedData->useFilters) {
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
                    })->sortBy('matricula');
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
            } else {
                $students = Student::findOrFail($validatedData->students);
            }

            /* @var $student Student */
            foreach ($students as $student) {
                $this->sendFreeMail($validatedData->subject, $validatedData->messageBody, $student);
            }
        }

        $params['sent'] = count(Mail::failures()) == 0;

        if ($params['sent']) {
            $params['message'] = 'Email enviado';
        } else {
            $params['message'] = 'Erro ao enviar email.';
        }

        return redirect()->route('admin.mensagem.index')->with($params);
    }
}
