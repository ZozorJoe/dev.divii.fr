<?php

namespace App\Http\Requests\Front\Shop;

use App\Exceptions\Coupon\CouponExpired;
use App\Exceptions\Coupon\CouponIsInvalid;
use App\Facades\Coupons;
use App\Models\Sale\Coupon;
use App\Models\Shop\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'coupon' => 'required|string',
        ];
    }

    /**
     * Handle request.
     *
     * @param Coupon $coupon
     * @param array $data
     * @return JsonResponse
     */
    public function handle(Coupon $coupon, array $data = array()): JsonResponse
    {
        $data = array_merge($this->validated(), $data);
        try {
            $coupon = Coupons::check($data['coupon']);
            $user = $this->user();
            if($user){
                $exists = $coupon->users()->where('users.id', $user->getKey())->exists();
                if($exists){
                    return response()->json([
                        'success' => false,
                        'message' => "Vous avez déjà utilisé ce code cadeau."
                    ]);
                }
            }
        } catch (CouponExpired | CouponIsInvalid $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }

        $session = $this->session();
        $session->put('coupon', $data['coupon']);

        $cartId = $session->get('cart');
        /** @var Order $order */
        $order = Order::find($cartId);
        if($order){
            $order->applyCoupon($coupon);
        }

        return response()->json([
            'success' => true,
            'message' => "Le code coupon a été bien appliqué."
        ]);
    }
}
