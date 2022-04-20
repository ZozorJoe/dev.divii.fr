<?php

namespace App\Traits;

use App\Facades\Vouchers;
use App\Models\Sale\Voucher;

trait HasVoucher
{
    /**
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return Voucher[]
     */
    public function createVouchers(int $amount, array $data = [], $expires_at = null): array
    {
        return Vouchers::create($this, $amount, $data, $expires_at);
    }

    /**
     * @param array $data
     * @param null $expires_at
     * @return Voucher
     */
    public function createVoucher(array $data = [], $expires_at = null): Voucher
    {
        return $this->createVouchers(1, $data, $expires_at)[0];
    }
}
