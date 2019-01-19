<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $student_name;
    private $confirmation_code; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student_name, $confirmation_code)
    {
        $this->student_name = $student_name;
        $this->confirmation_code = $confirmation_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__("Confirmación de correo"))
            ->markdown('emails.confirm_email') //Template
            ->with('student_name', $this->student_name)
            ->with('confirmation_code', $this->confirmation_code);
    }
}
