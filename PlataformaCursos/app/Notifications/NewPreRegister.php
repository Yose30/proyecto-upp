<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPreRegister extends Notification
{
    use Queueable;

    protected $pre_register;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pre_register)
    {
        $this->pre_register = $pre_register;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'pre_register' => $this->pre_register
        ];
    }
}
