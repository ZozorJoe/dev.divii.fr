<?php

namespace App\Http\Controllers\Api\v1\Front\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\Shop\CheckoutRequest;
use App\Models\Shop\Order;
use App\Repositories\Shop\OrderRepository;
use Illuminate\Http\JsonResponse;

class CheckoutController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param CheckoutRequest $request
     * @param OrderRepository $orderRepository
     * @return JsonResponse
     */
    public function store(CheckoutRequest $request, OrderRepository $orderRepository): JsonResponse
    {
        $request->setOrderRepository($orderRepository);

        $cartId = $request->session()->get('cart');
        $cart = Order::find($cartId);
        if($cart){
            return $request->handle($cart);
        }

        return response()->json([
            'success' => false,
        ]);
    }

}
