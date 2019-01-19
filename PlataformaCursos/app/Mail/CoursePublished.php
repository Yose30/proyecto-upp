<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoursePublished extends Mailable
{
    use Queueable, SerializesModels;

    private $teacher_name;
    private $teacher_lastname;
    private $course_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($teacher_name, $teacher_lastname, $course_name)
    {
        $this->teacher_name = $teacher_name;
        $this->teacher_lastname = $teacher_lastname;
        $this->course_name = $course_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this
            ->subject(__("Curso publicado"))
            ->markdown('emails.course_published') //Template
            ->with('teacher_name', $this->teacher_name)
            ->with('teacher_lastname', $this->teacher_lastname)
            ->with('course_name', $this->course_name);
    }
}
