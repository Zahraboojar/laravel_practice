<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Ghasedak\GhasedaksmsApi;
use DateTimeImmutable;
use Ghasedak\DataTransferObjects\Request\SingleMessageDTO;
use Ghasedak\Exceptions\GhasedakSMSException;

class GhasedakChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toGhasedakSms($notifiable);
        $apikey = config('services.ghasedak.key');
        $ghasedaksms = new GhasedaksmsApi($apikey);
        $sendDate = new DateTimeImmutable('now');
        $lineNumber = '30005078';

          try {
              $response = $ghasedaksms->sendSingle(new SingleMessageDTO(
                  sendDate: $sendDate,
                  lineNumber: $lineNumber,
                  receptor: $data['number'],
                  message: $data['text']
              ));
              var_dump($response);
          } catch (GhasedakSMSException $e) {
              var_dump($e->getMessage());
          }
    }
}