<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestLowStudent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $message;
    protected $student_name;
    protected $student_slug;
    protected $profesor;

    public function __construct($message, $student_name, $student_slug, $profesor)
    {
        $this->message = $message;
        $this->student_name = $student_name;
        $this->student_slug = $student_slug;
        $this->profesor = $profesor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__("Solicitud de baja"))
            ->markdown('emails.request_low') //Template
            ->with('message', $this->message)
            ->with('student_name', $this->student_name)
            ->with('student_slug', $this->student_slug)
            ->with('profesor', $this->profesor);
    }
}
