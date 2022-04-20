<?php

namespace App\Listeners\User;

use App\Events\Auth\Registered;

class SendCouponNotification
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        info("SendCouponNotification");
    }
}
