<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification
{
    use Queueable;

    public $itemCode;

    public function __construct($itemCode)
    {
        $this->itemCode = $itemCode;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [

            'message' =>

                'Low stock detected for item : '
                . $this->itemCode
        ];
    }
}