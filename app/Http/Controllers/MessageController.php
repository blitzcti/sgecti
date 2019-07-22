<?php

namespace App\Http\Controllers;

use App\Mail\InternshipProposalMail;
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

    public function sendInternshipProposalMail()
    {
        $proposal = Proposal::find(1);
        $student = (object)[
            'matricula' => 1757037,
            'nome' => 'Dhiego Cassiano Fogaça Barbosa',
            'email' => 'modscleo4@outlook.com'
        ];
        Mail::to($student->email)->send(new InternshipProposalMail($student, $proposal));

        return view('coordinator.message.index');
    }
}
