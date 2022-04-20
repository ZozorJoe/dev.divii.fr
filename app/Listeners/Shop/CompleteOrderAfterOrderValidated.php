<?php

namespace App\Listeners\Shop;

use App\Events\Order\OrderValidated;

class CompleteOrderAfterOrderValidated
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
        if($order){
            // Complete order
            $order->complete();
        }
    }
}
