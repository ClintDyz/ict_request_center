<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Rstbl;

class ApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;

    /**
     * Create a new message instance.
     */
    public function __construct(Rstbl $applicant)
    {
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Resource Speaker Application Submitted')
                    ->view('emails.application_submitted');
    }
}
