<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Auth;

class FinalReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = Auth::user();
        $title = 'Relatório final de estágio';
        $from = 'informatica@cti.feb.unesp.br';

        return $this->from($from)
            ->view('emails.finalReport')
            ->subject($title)
            ->with([
                'user' => $user,
                'title' => $title,
                'student' => $this->student,
            ]);
    }
}
