<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActiveCode extends Notification
{
    use Queueable;

    public $code;
    public $phonenumber;
    /**
     * Create a new notification instance.
     */
    public function __construct($code, $phonenumber)
    {
        $this->code = $code;
        $this->phonenumber =$phonenumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [GhasedakChannel::class];
    }

    public function toGhasedakSms($notifiable)
    {
        return [
            'text' => 'ghasedak massage \n',
            'number' => $this->phonenumber,
        ];
    }
}
