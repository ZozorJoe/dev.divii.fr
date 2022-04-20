<?php

namespace App\Exceptions\Voucher;

class VoucherIsInvalid extends \Exception
{
    protected $code;

    public static function withCode(string $code): VoucherIsInvalid
    {
        return new static('Le code cadeau '.$code.' n\'est pas valide.', $code);
    }

    public function __construct($message, $code)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getVoucherCode()
    {
        return $this->code;
    }
}
