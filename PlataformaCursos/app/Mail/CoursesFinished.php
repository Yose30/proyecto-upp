<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoursesFinished extends Mailable
{
    use Queueable, SerializesModels;

    private $user_name;
    private $lastName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $lastName)
    {
        $this->user_name = $user_name;
        $this->lastName = $lastName;
    }

    /**
     * Build the message.
     *
     * @return $this 
     */
    public function build()
    {
        return $this
            ->subject(__("Cursos concluidos"))
            ->markdown('emails.courses_finished') //Template
            ->with('user_name', $this->user_name)
            ->with('lastName', $this->lastName);
    }
}
