<?php

namespace App\Notifications\Order;

use App\Models\Shop\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderComplete extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
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
        ];
        return (new MailMessage)
            ->subject(__('emails.order.complete.subject', $data))
            ->markdown('emails.order.complete', ['user' => $notifiable, 'model' => $this->order, 'data' => $data]);
    }

}
