<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $user;
    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }


    public function via($notifiable)
    {
        return ['mail','database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Low Stock Notification Mail')
                    ->line($this->message['body'])
                    ->line($this->message['item'])
                    ->line($this->message['quantity'])
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->first_name . '' .$this->user->last_name,
        ];
    }
}
