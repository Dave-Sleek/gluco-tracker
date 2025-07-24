<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactSubmitted extends Notification
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail']; // or ['mail', 'database'] if you want both
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Contact Submission')
                    ->greeting('Hello!')
                    ->line('You’ve received a new contact message:')
                    ->line('**Name:** ' . $this->data['name'])
                    ->line('**Email:** ' . $this->data['email'])
                    ->line('**Message:**')
                    ->line($this->data['message'])
                    ->salutation('— GlucoTracker Bot');
    }

    public function toDatabase($notifiable)
{
    return [
        'type' => 'contact',
        'message' => $this->data['message'],
        'sender' => $this->data['name'],
        'email' => $this->data['email'],
        'created_at' => now(),
    ];
}
}
