<?php

namespace App\Listeners\Checkout;

use App\Events\Order\Checkout;

class RemoveCardSession
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Checkout  $event
     * @return void
     */
    public function handle(Checkout $event)
    {
        request()->session()->remove('cart');
    }
}
