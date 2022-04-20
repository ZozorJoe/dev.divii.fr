<?php

namespace App\Observers\Shop;

use App\Events\Order\OrderCreated;
use App\Events\Order\OrderDeleted;
use App\Events\Order\OrderUpdated;
use App\Models\Shop\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        event(new OrderCreated($order));
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        event(new OrderUpdated($order));
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        event(new OrderDeleted($order));
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
