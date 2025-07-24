<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎉 Welcome to GlucoTracker')
            ->greeting('Hello ' . $notifiable->full_name . ' 👋')
            ->line('Thank you for signing up! You’re now ready to monitor your glucose levels and take control of your health.')
            ->action('Go to Dashboard', url('/dashboard'))
            ->line('If you have any questions, we’re here to help!');
    }
}
