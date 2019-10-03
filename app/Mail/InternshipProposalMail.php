<?php

namespace App\Mail;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Auth;

class InternshipProposalMail extends Mailable
{
    use Queueable, SerializesModels;

    private $student;
    private $proposal;

    /**
     * Create a new message instance.
     *
     * @param $student
     * @param Proposal $proposal
     */
    public function __construct($student, Proposal $proposal)
    {
        $this->student = $student;
        $this->proposal = $proposal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = Auth::user();
        $title = 'Vaga de estágio';
        $from = 'informatica@cti.feb.unesp.br';

        return $this->from($from)
            ->view('emails.internshipProposal')
            ->subject($title)
            ->with([
                'user' => $user,
                'title' => $title,
                'student' => $this->student,
                'proposal' => $this->proposal,
            ]);
    }
}
