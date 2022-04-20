<?php

namespace App\Events\Order;

use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Checkout
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Order
     */
    public $order;

    /**
     * @var Payment
     */
    public $payment;

    /**
     * Checkout constructor.
     * @param Order $order
     * @param Payment $payment
     */
    public function __construct(Order $order, Payment $payment)
    {
        $this->order = $order;
        $this->payment = $payment;
    }
}
