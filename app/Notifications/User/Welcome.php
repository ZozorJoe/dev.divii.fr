<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Welcome extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
        ];
        return (new MailMessage)
            ->subject(__('emails.user.welcome.subject', $data))
            ->markdown('emails.user.welcome', ['user' => $notifiable, 'data' => $data]);
    }

}
