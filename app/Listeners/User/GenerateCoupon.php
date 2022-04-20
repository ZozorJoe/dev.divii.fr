<?php

namespace App\Listeners\User;

use App\Events\Sale\CouponCreated;
use App\Events\User\UserWelcome;
use App\Facades\Coupons;
use App\Models\Sale\Coupon;
use Carbon\Carbon;

class GenerateCoupon
{
    /**
     * Handle the event.
     *
     * @param UserWelcome $event
     * @return void
     */
    public function handle(UserWelcome $event)
    {
        $codes = Coupons::generate();

        $start = Carbon::createFromFormat("Y-m-d H:i:s", "2022-04-04 00:00:00");
        $start = $start->isFuture() ? $start : now();

        $coupon = new Coupon();
        $coupon->name = $codes[0];
        $coupon->type = Coupon::TYPE_PERCENT;
        $coupon->value = 20;
        $coupon->active = 1;
        $coupon->start_date = $start->isFuture() ? $start : now();
        $coupon->end_date = $start->copy()->addMonth();
        $coupon->limit_number = 1;
        $coupon->limit_user = 1;
        $coupon->save();

        $coupon->users()->attach($event->user->getKey());

        event(new CouponCreated($coupon, $event->user));
    }
}
