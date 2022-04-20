<?php

namespace App\Http\Controllers\Api\v1\Front\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\Shop\CartRequest;
use App\Http\Resources\Front\Shop\OrderResource;
use App\Models\Shop\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Order $order
     * @return OrderResource|JsonResponse
     */
    public function index(Request $request, Order $order)
    {
        $cartId = $request->session()->get('cart');
        $order = Order::find($cartId);
        if($order){
            $order->load(['items', 'items.orderable']);

            return new OrderResource($order);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CartRequest $request
     * @param Order $order
     * @return OrderResource|JsonResponse
     */
    public function store(CartRequest $request, Order $order)
    {
        $cartId = $request->session()->get('cart');
        $cart = Order::find($cartId);
        try{
            if($cart){
                $order = $request->handle($cart);
            }else{
                $order = $request->handle($order);
            }
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        if($order){
            $request->session()->put('cart', $order->getKey());

            $order->load(['items', 'items.orderable']);

            return new OrderResource($order);
        }

        return response()->json([
            'success' => false,
            'message' => "Nous n'avons pas pu ajouter votre demande dans le panier."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Request $request, Order $order): JsonResponse
    {
        $itemId = $request->get('id');
        if($order->getKey() && $itemId > 0){
            $item = $order->items()
                ->findOrFail($itemId);

            $delete = $item->delete();
            if($delete){
                $exists = $order->items()->exists();
                if(!$exists){
                    $order->delete();
                    $request->session()->remove('cart');
                }

                return response()->json([
                    'success' => true,
                ]);
            }
        }

        return response()->json([
            'success' => false,
        ]);
    }

}
