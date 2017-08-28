<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StdSubmitNewForm extends Notification
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
            'data' => $this->frm->nim .' mengajukan permohonan  <br />' .$this->frm->jenis_frm,
            'id' => $this->frm->id
        ];
    }

    //
    // public function toDatabase()
    // {
    //   return [
    //     'id' => 1,
    //     'title' =>
    //   ]
    // }

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }
}
