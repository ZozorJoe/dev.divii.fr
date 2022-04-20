<?php

namespace App\Observers\Shop;

use App\Models\Shop\Consultation;
use App\Models\Shop\OrderItem;

class OrderItemObserver
{
    /**
     * Handle the OrderItem "created" event.
     *
     * @param OrderItem $orderItem
     * @return void
     */
    public function created(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "updated" event.
     *
     * @param OrderItem $orderItem
     * @return void
     */
    public function updated(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "deleted" event.
     *
     * @param OrderItem $orderItem
     * @return void
     */
    public function deleted(OrderItem $orderItem)
    {
        $orderable = $orderItem->orderable;
        if($orderable instanceof Consultation){
            $orderable->delete();
        }
    }

    /**
     * Handle the OrderItem "restored" event.
     *
     * @param OrderItem $orderItem
     * @return void
     */
    public function restored(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "force deleted" event.
     *
     * @param OrderItem $orderItem
     * @return void
     */
    public function forceDeleted(OrderItem $orderItem)
    {
        //
    }
}
