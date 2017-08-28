<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdmReturnForm extends Notification
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
            'data' => 'Permohonan anda <br />' .$this->frm->jenis_frm .' gagal diproses',
            'id' => $this->frm->id
        ];
    }
}
