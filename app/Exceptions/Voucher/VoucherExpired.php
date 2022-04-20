<?php

namespace App\Exceptions\Voucher;

use App\Models\Sale\Voucher;

class VoucherExpired extends \Exception
{
    protected $message = 'Ce code cadeau a déjà expiré.';

    protected $voucher;

    public static function create(Voucher $voucher): VoucherExpired
    {
        return new static($voucher);
    }

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }
}
