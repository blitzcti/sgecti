<?php

namespace App\Http\Controllers;

use App\Mail\BimestralReportMail;
use App\Mail\FreeMail;
use App\Mail\ImportantMail;
use App\Mail\InternshipProposalMail;
use App\Models\NSac\Student;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    function __construct()
    {
        $this->middleware('role:admin', ['only' => ['adminIndex']]);
        $this->middleware('coordinator', ['only' => ['coordinatorIndex']]);
    }

    public function adminIndex()
    {
        return view('admin.message.index');
    }

    public function coordinatorIndex()
    {
        $courses = Auth::user()->coordinator_of;

        return view('coordinator.message.index')->with(['courses' => $courses]);
    }

    public function sendBimestralReportMail($student_id = 1757037)
    {
        $student = Student::find($student_id);

        return Mail::to($student->email)->send(new BimestralReportMail($student));
    }

    public function sendInternshipProposalMail($proposal_id = 1, $student_id = 1757037)
    {
        $proposal = Proposal::find($proposal_id);
        $student = Student::find($student_id);

        return Mail::to($student->email)->send(new InternshipProposalMail($student, $proposal));
    }

    public function sendImportantMail($messageBody, $student_id = 1757037)
    {
        $student = Student::find($student_id);

        return Mail::to($student->email)->send(new ImportantMail($student, $messageBody));
    }

    public function sendFreeMail($subject, $messageBody, $student_id = 1757037)
    {
        $student = Student::find($student_id);

        return Mail::to($student->email)->send(new FreeMail($subject, $messageBody));
    }

    public function sendEmail(Request $request)
    {
        $params = [];
        $validatedData = (object)$request->validate([
            'grades' => 'nullable|array',
            'periods' => 'nullable|array',
            'courses' => 'nullable|array',
            'internships' => 'nullable|array',
            'message' => 'nullable|numeric|min:0|max:3',
            'subject' => 'required_if:message,3|max:100',
            'messageBody' => 'required_if:message,2|required_if:message,3|max:8000',
        ]);

        if (config('app.debug')) {
            switch ($validatedData->message) {
                case 0:
                    $this->sendBimestralReportMail();
                    break;

                case 1:
                    $this->sendInternshipProposalMail();
                    break;

                case 2:
                    $this->sendImportantMail($validatedData->messageBody);
                    break;

                case 3:
                    $this->sendFreeMail($validatedData->subject, $validatedData->messageBody);
                    break;
            }

        } else {

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
