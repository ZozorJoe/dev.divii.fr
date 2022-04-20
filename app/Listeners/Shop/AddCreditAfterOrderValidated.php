<?php

namespace App\Listeners\Shop;

use App\Events\Order\OrderValidated;
use App\Events\User\CreditAdded;
use App\Models\Catalog\Product;
use App\Models\User\Credit;

class AddCreditAfterOrderValidated
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
        if($order && $order->user){
            $items = $order->items;
            foreach ($items as $item){
                $product = $item->orderable;
                if($product instanceof Product){
                    $value = $item->quantity * $product->getTotalCredit();

                    $credit = new Credit();
                    $credit->value = $value;
                    $credit->original_value = $value;
                    $credit->valid_until = now()->addYear();

                    $order->user
                        ->credits()
                        ->save($credit);

                    // Trigger event
                    event(new CreditAdded($credit));
                }
            }
        }
    }
}
