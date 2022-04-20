<?php

namespace App\Listeners\Shop;

use App\Events\Order\OrderValidated;

class MarkCouponAfterOrderValidated
{
    /**
     * Handle the event.
     *
     * @param OrderValidated $event
     * @return void
     */
    public function handle(OrderValidated $event)
    {
        $order = $event->order;
        if($order && $order->coupon){
            $order->coupon->times_used++;
            $order->coupon->save();
        }
    }
}
