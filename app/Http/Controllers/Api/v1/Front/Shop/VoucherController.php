<?php

namespace App\Http\Controllers\Api\v1\Front\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\Shop\VoucherRequest;
use App\Models\Sale\Voucher;
use Illuminate\Http\JsonResponse;

class VoucherController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param VoucherRequest $request
     * @param Voucher $voucher
     * @return JsonResponse
     */
    public function store(VoucherRequest $request, Voucher $voucher): JsonResponse
    {
        return $request->handle($voucher);
    }

}
