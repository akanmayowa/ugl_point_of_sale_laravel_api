<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public array $userData;

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Password Reset - Notification')
                    ->line('Full Name: ' . $this->userData['first_name'] . ',  ' . $this->userData['last_name'])
                    ->line('Reset Token: ' . $this->userData['token'])
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
