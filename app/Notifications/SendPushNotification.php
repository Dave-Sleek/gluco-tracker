<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class SendPushNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class]; // Add others here if needed
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setNotification([
                'title' => 'New Alert',
                'body' => $this->data['message'],
            ])
            ->setData([
                'type' => 'admin_alert',
                'message_id' => $this->data['id'] ?? null
            ]);
    }
}
