<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendToNewUser extends Mailable
{
    use Queueable, SerializesModels;
    private $user_name;
    private $last_name;
    private $clave;
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $last_name, $clave, $password)
    {
        $this->user_name = $user_name;
        $this->last_name = $last_name;
        $this->clave = $clave;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__("Datos para acceder a deei"))
            ->markdown('emails.new_user') //Template
            ->with('user_name', $this->user_name)
            ->with('last_name', $this->last_name)
            ->with('clave', $this->clave)
            ->with('password', $this->password);
    }
}
