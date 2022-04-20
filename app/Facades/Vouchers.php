<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Voucher\Vouchers
 */
class Vouchers extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'vouchers';
    }
}
