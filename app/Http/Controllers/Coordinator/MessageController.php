<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\SendMail;
use App\Mail\BimestralReportMail;
use App\Mail\FreeMail;
use App\Mail\ImportantMail;
use App\Mail\InternshipProposalMail;
use App\Models\Internship;
use App\Models\NSac\Student;
use App\Models\Proposal;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
    }

    public function index(Request $request)
    {
        $cIds = Auth::user()->coordinator_courses_id;
        $courses = Auth::user()->coordinator_of;
        $p = $request->p;
        if (!ctype_digit($p)) {
            $p = null;
        }

        $students = Student::actives()->filter(function ($student) use ($cIds) {
            return in_array($student->course_id, $cIds);
        });

        $proposals = Proposal::approved();

        return view('coordinator.message.index')->with([
            'courses' => $courses,
            'students' => $students,
            'proposals' => $proposals,
            'p' => $p,
        ]);
    }

    public function sendBimestralReportMail(Student $student)
    {
        return Mail::to($student->email)->send(new BimestralReportMail($student));
    }

    public function sendInternshipProposalMail(Proposal $proposal, Student $student)
    {
        return Mail::to($student->email)->send(new InternshipProposalMail($student, $proposal));
    }

    public function sendImportantMail($messageBody, Student $student)
    {
        return Mail::to($student->email)->send(new ImportantMail($student, $messageBody));
    }

    public function sendFreeMail($subject, $messageBody, Student $student)
    {
        return Mail::to($student->email)->send(new FreeMail($subject, $messageBody));
    }

    public function sendEmail(SendMail $request)
    {
        $params = [];
        $validatedData = (object)$request->validated();

        if (!config('app.debug')) {
            $student = Student::find(1757037);

            switch ($validatedData->message) {
                case 0:
                    $this->sendBimestralReportMail($student);
                    break;

                case 1:
                    $proposal = Proposal::find(1);
                    $this->sendInternshipProposalMail($proposal, $student);
                    break;

                case 2:
                    $this->sendImportantMail($validatedData->messageBody, $student);
                    break;

                case 3:
                    $this->sendFreeMail($validatedData->subject, $validatedData->messageBody, $student);
                    break;
            }
        } else {
            if ($validatedData->useFilters) {
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

                if (isset($validatedData->classes)) {
                    $classes = $validatedData->classes;
                    $students = $students->filter(function ($student) use ($classes) {
                        return in_array($student->class, $classes);
                    });
                }
            } else {
                $students = Student::findOrFail($validatedData->students);
            }

            switch ($validatedData->message) {
                case 0:
                    /*foreach ($students as $student) {
                        $this->sendBimestralReportMail($student->matricula);
                    }*/

                    break;

                case 1:
                    $proposal = Proposal::find($validatedData->proposal);
                    /*foreach ($students as $student) {
                        $this->sendInternshipProposalMail($proposal, $student);
                    }*/

                    break;

                case 2:
                    /*foreach ($students as $student) {
                        $this->sendImportantMail($validatedData->messageBody, $student);
                    }*

                    break;

                case 3:
                    /*foreach ($students as $student) {
                        $this->sendFreeMail($validatedData->subject, $validatedData->messageBody, $student);
                    }*/

                    break;
            }
        }

        $params['sent'] = count(Mail::failures()) == 0;

        if ($params['sent']) {
            $params['message'] = 'Email enviado';
        } else {
            $params['message'] = 'Erro ao enviar email.';
        }

        return redirect()->route('coordenador.mensagem.index')->with($params);
    }
}
