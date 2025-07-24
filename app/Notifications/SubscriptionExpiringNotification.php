<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SubscriptionExpiringNotification extends Notification
{
    protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // email + notification system
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Subscription is Expiring Soon')
            ->line("Hi {$notifiable->name}, your subscription for {$this->invoice->plan} is expiring on {$this->invoice->issued_at}.")
            ->action('Renew Now', url('subscription.renew'))
            ->line('Thanks for using GlucoTracker!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Your subscription to {$this->invoice->plan} is expiring soon.",
            'expires_at' => $this->invoice->issued_at,
            'reference' => $this->invoice->reference,
        ];
    }
}
