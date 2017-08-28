<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class KtuPassForm extends Notification
{
    use Queueable;

    protected $frm;

    public function __construct($frm)
    {
      $this->frm = $frm;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'data' => 'Ktu membagikan <br />' .$this->frm->jenis_frm.' untuk diselesaikan',
            'id' => $this->frm->id
        ];
    }
}
