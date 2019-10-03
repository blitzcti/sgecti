<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Auth;

class FreeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $title;
    private $messageBody;

    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $messageBody
     */
    public function __construct($subject, $messageBody)
    {
        $this->title = $subject;
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
        $title = $this->title;
        $from = 'informatica@cti.feb.unesp.br';

        return $this->from($from)
            ->view('emails.freeMessage')
            ->subject($title)
            ->with([
                'user' => $user,
                'title' => $title,
                'messageBody' => $this->messageBody,
            ]);
    }
}
