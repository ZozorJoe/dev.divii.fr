<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderComplete;

class SendOrderCompleteNotification
{
    /**
     * Handle the event.
     *
     * @param  OrderComplete  $event
     * @return void
     */
    public function handle(OrderComplete $event)
    {
        /*
        $order = $event->order;
        if($order && $order->user){
            $order->user->notify(new \App\Notifications\Order\OrderComplete($order));
        }
        */

    }
}
