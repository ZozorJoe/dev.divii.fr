<?php

namespace App\Notifications\User;

use App\Models\Sale\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Birthday extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Coupon|null
     */
    private $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

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
        $tz = $notifiable->timezone ?? "Europe/Paris";
        $date = $this->coupon->end_date->timezone($tz);
        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
            'url' => route('calendar'),
            'reduction' => $this->coupon->reduction,
            'coupon' => $this->coupon->name,
            'expiration' => $date->format("d/m/Y"),
        ];
        return (new MailMessage)
            ->subject(__('emails.user.birthday.subject', $data))
            ->markdown('emails.user.birthday', ['user' => $notifiable, 'data' => $data,]);
    }

}
