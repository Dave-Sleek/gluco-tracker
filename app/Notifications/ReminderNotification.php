<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reminder;
    protected $latestReading;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param  object  $reminder
     * @param  object|null  $latestReading
     * @param  object  $user
     */
    public function __construct($reminder, $latestReading = null, $user)
    {
        $this->reminder = $reminder;
        $this->latestReading = $latestReading;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('emails.reminder', [
                'reminder' => $this->reminder,
                'latestReading' => $this->latestReading,
                'user' => $this->user,
            ]);
    }

    /**
     * Optional: Represent the notification as an array (for database/storage).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->reminder->subject,
            'body' => $this->reminder->body,
            'scheduled' => $this->reminder->scheduled_time ?? null,
            'recurrence' => $this->reminder->recurrence ?? null,
            'last_glucose' => $this->latestReading->converted_value ?? null,
        ];
    }
}
