<?php

namespace App\Http\Controllers\Api\v1\Front\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\Shop\CouponRequest;
use App\Models\Sale\Coupon;
use Illuminate\Http\JsonResponse;

class CouponController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return JsonResponse
     */
    public function store(CouponRequest $request, Coupon $coupon): JsonResponse
    {
        return $request->handle($coupon);
    }

}
