<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Coupon\Coupons
 * @method static check(mixed $coupon)
 */
class Coupons extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'coupons';
    }
}
