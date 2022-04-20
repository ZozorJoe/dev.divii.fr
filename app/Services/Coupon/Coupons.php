<?php

namespace App\Services\Coupon;

use App\Exceptions\Coupon\CouponException;
use App\Exceptions\Coupon\CouponExpired;
use App\Exceptions\Coupon\CouponIsInvalid;
use App\Exceptions\Coupon\CouponMaxUsedAttempt;
use App\Models\Sale\Coupon;
use Illuminate\Database\Eloquent\Model;

class Coupons
{
    /** @var CouponGenerator */
    private $generator;

    public function __construct(CouponGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generate the specified amount of codes and return
     * an array with all the generated codes.
     *
     * @param int $amount
     * @return array
     */
    public function generate(int $amount = 1): array
    {
        $codes = [];

        for ($i = 1; $i <= $amount; $i++) {
            $codes[] = $this->getUniqueCoupon();
        }

        return $codes;
    }

    /**
     * @return string
     */
    protected function getUniqueCoupon(): string
    {
        $coupon = $this->generator->generateUnique();

        while (Coupon::whereName($coupon)->count() > 0) {
            $coupon = $this->generator->generateUnique();
        }

        return $coupon;
    }

    /**
     * @param string $code
     * @return Coupon
     * @throws CouponException
     */
    public function check(string $code): Coupon
    {
        info("Checking coupon $code");
        /** @var Coupon $coupon */
        $coupon = Coupon::where('name', '=', $code)->first();

        if (is_null($coupon)) {
            info("Coupon $code not found");
            throw new CouponException("Le code coupon $code n'est plus valide.");
        }

        if (!$coupon->active) {
            throw new CouponException("Le code coupon $code n'est plus utilisable.");
        }

        if ($coupon->isExpired()) {
            info("Coupon $code expired");
            throw new CouponException("Le code coupon $code a déjà expiré.");
        }

        if ($coupon->limit_number && ($coupon->times_used >= $coupon->limit_number)) {
            throw new CouponException("Le code coupon $code a déjà utilisé $coupon->times_used fois.");
        }

        info("Coupon $code exists");
        return $coupon;
    }

    /**
     * @param int $amount
     * @param string $type
     * @param int $value
     * @param int $delay
     * @param int $limit
     * @return array
     */
    public function create(int $amount = 1, string $type = Coupon::TYPE_PERCENT, int $value = 20, int $delay = 15, int $limit = 1): array
    {
        $coupons = [];

        foreach ($this->generate($amount) as $couponCode) {
            $coupons[] = Coupon::create([
                'type' => $type,
                'name' => $couponCode,
                'value' => $value,
                'active' => 1,
                'start_date' => now(),
                'end_date' => now()->addDays($delay),
                'limit_number' => $limit,
            ]);
        }

        return $coupons;
    }
}
