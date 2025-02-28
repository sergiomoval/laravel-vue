<?php

namespace App\Notifications\Administration\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class InviteNotification extends Notification
{
    use Queueable;
    protected $notification_url;

     /**
     * Create a new notification instance.
     */
    public function __construct($notification_url)
    {
        $this->notification_url = $notification_url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('WhatsApp Bot Invitation'))
            ->greeting(Lang::get('Hello!'))
            ->line(Lang::get('This is to invite you to join our platform'). ' ' . config('app.name'))
            ->action(Lang::get('Sign Up'), $this->notification_url)
            ->line(Lang::get("Thank you for using our platform!"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
