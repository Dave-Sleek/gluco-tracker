<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class SendWebPushNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['webpush'];
    }

    public function toWebPush($notifiable, $notification)
    {
        return WebPushMessage::create()
            ->title('New Admin Message')
            ->body($this->data['message']);
    }
}
