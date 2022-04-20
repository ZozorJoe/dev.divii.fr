<?php

namespace App\Events\Sale;

use App\Models\Sale\Coupon;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class CouponCreated
{
    use SerializesModels;

    public $user;

    /** @var Coupon */
    public $coupon;

    public function __construct(Coupon $coupon, User $user)
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }
}
