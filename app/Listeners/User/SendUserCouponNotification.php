<?php

namespace App\Listeners\User;

use App\Events\Sale\CouponCreated;
use App\Notifications\User\UserCoupon;

class SendUserCouponNotification
{
    /**
     * Handle the event.
     *
     * @param  CouponCreated  $event
     * @return void
     */
    public function handle(CouponCreated $event)
    {
        info("SendUserCouponNotification");
        if($event->user && $event->coupon){
            $event->user->notify(new UserCoupon($event->coupon));
        }
    }
}
