<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmEmailNotification extends Notification
{
    use Queueable;

    public $token = null;

    /**
     * Create a new notification instance.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(trans('app.global.emails.confirmation-email.title'))
                    ->greeting(trans('app.global.emails.confirmation-email.greeting'))
                    ->line(trans('app.global.emails.confirmation-email.title'))
                    ->action(trans('app.global.emails.confirmation-email.button'), route_with_subdomain('parameters_confirm_email', ['token' => $this->token]))
                    ->line(trans('app.global.emails.confirmation-email.outro'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
