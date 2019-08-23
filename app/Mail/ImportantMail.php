<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class ImportantMail extends Mailable
{
    use Queueable, SerializesModels;

    private $student;
    private $messageBody;

    /**
     * Create a new message instance.
     *
     * @param $student
     * @param $messageBody
     */
    public function __construct($student, $messageBody)
    {
        $this->student = $student;
        $this->messageBody = $messageBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = Auth::user();
        $title = 'Aviso importante';
        $from = 'informatica@cti.feb.unesp.br';

        return $this->from($from)
            ->view('emails.importantMessage')
            ->subject($title)
            ->with([
                'user' => $user,
                'title' => $title,
                'student' => $this->student,
                'messageBody' => $this->messageBody,
            ]);
    }
}
