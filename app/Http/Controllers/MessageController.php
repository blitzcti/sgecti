<?php

namespace App\Http\Controllers;

use App\Mail\InternshipProposalMail;
use App\Models\NSac\Student;
use App\Models\Proposal;
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

    public function sendInternshipProposalMail($proposal_id = 1, $student_id = 1757037)
    {
        $proposal = Proposal::find($proposal_id);
        $student = Student::find($student_id);

        Mail::to($student->email)->send(new InternshipProposalMail($student, $proposal));

        return redirect()->route('coordenador.mensagem.index');
    }

    public function sendEmail()
    {

    }
}
