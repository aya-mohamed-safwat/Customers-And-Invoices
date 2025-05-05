<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class EmailVerificationNotification extends Notification
{
    use Queueable;

    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    private $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
        $this->message='use the code for verfication the email';
        $this->subject='verification needed';
        $this->fromEmail='test@gmail.com';
        $this->mailer='smtp';
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
        ->mailer($this->mailer)
        ->subject($this->subject)
        ->greeting('Hello')
        ->line($this->message)
        ->line('Code: ' .$this->otp);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
