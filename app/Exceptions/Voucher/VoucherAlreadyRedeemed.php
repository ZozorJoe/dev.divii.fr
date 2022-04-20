<?php

namespace App\Exceptions\Voucher;

use App\Models\Sale\Voucher;

class VoucherAlreadyRedeemed extends \Exception
{
    protected $message = 'The voucher was already redeemed.';

    protected $voucher;

    public static function create(Voucher $voucher)
    {
        return new static($voucher);
    }

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }
}
