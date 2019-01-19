<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewMessageChat extends Notification
{
    use Queueable;
    protected $message;
    protected $conversation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $conversation)
    {
        $this->message = $message;
        $this->conversation = $conversation;
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
            'message' => $this->message,
            'conversation' => $this->conversation,
            'user' => auth()->user()
        ];
    }
}
