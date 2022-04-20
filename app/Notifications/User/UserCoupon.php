<?php

namespace App\Notifications\User;

use App\Models\Sale\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCoupon extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Coupon
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
        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
            'reduction' => $this->coupon->reduction,
            'coupon' => $this->coupon->name,
        ];
        return (new MailMessage)
            ->subject(__('emails.user.coupon.subject', $data))
            ->markdown('emails.user.coupon', ['user' => $notifiable, 'data' => $data]);
    }

}
