<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccessToCourse extends Mailable
{
    use Queueable, SerializesModels;
    private $student_name;
    private $student_lastName;
    private $teacher_name;
    private $teacher_lastname;
    private $course_name;
    private $slug;

    /**
     * Create a new message instance.
     *
     * @return void 
     */
    public function __construct($student_name, $student_lastName, $teacher_name, $teacher_lastname, $course_name, $slug)
    {
        $this->student_name = $student_name;
        $this->student_lastName = $student_lastName;
        $this->teacher_name = $teacher_name;
        $this->teacher_lastname = $teacher_lastname;
        $this->course_name = $course_name;
        $this->slug = $slug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__("Acceso a curso"))
            ->markdown('emails.access_to_course') //Template
            ->with('student_name', $this->student_name)
            ->with('student_lastName', $this->student_lastName)
            ->with('teacher_name', $this->teacher_name)
            ->with('teacher_lastname', $this->teacher_lastname)
            ->with('course_name', $this->course_name)
            ->with('slug', $this->slug);
    }
}
