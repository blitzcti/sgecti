<?php

namespace App\Notifications;

use App\Mail\InternshipProposalMail;
use App\Models\NSac\Student;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class NewInternshipProposalNotification extends Notification
{
    use Queueable;

    private $student;
    private $proposal;
    private $details;

    /**
     * Create a new notification instance.
     *
     * @param $details
     */
    public function __construct($details)
    {
        $this->student = Student::find($details['ra']);
        $this->proposal = Proposal::find($details['proposal_id']);
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return Mailable
     */
    public function toMail($notifiable)
    {
        return (new InternshipProposalMail($this->student, $this->proposal))->to($this->student->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
