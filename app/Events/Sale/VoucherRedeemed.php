<?php

namespace App\Events\Sale;

use App\Models\Sale\Voucher;
use Illuminate\Queue\SerializesModels;

class VoucherRedeemed
{
    use SerializesModels;

    public $user;

    /** @var Voucher */
    public $voucher;

    public function __construct($user, Voucher $voucher)
    {
        $this->user = $user;
        $this->voucher = $voucher;
    }
}
