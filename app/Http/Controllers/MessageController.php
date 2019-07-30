<?php

namespace App\Http\Controllers;

use App\Mail\InternshipProposalMail;
use App\Models\NSac\Student;
use App\Models\Proposal;
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
        return view('coordinator.message.index');
    }

    public function sendInternshipProposalMail($proposal_id = 1, $student_id = 1757037)
    {
        $proposal = Proposal::find($proposal_id);
        $student = Student::find($student_id);

        Mail::to($student->email)->send(new InternshipProposalMail($student, $proposal));

        return view('coordinator.message.index');
    }
}
