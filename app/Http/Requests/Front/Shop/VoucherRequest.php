<?php

namespace App\Http\Requests\Front\Shop;

use App\Exceptions\Voucher\VoucherExpired;
use App\Exceptions\Voucher\VoucherIsInvalid;
use App\Facades\Vouchers;
use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Sale\Voucher;
use App\Models\Shop\Consultation;
use App\Models\Shop\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class VoucherRequest extends FormRequest
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
            'voucher' => 'required|string',
        ];
    }

    /**
     * Handle request.
     *
     * @param Voucher $voucher
     * @param array $data
     * @return JsonResponse
     */
    public function handle(Voucher $voucher, array $data = array()): JsonResponse
    {
        $data = array_merge($this->validated(), $data);
        $data['voucher'] = strtoupper($data['voucher']);

        try {
            $voucher = Vouchers::check($data['voucher']);
            $model = $voucher->model;
            if(!$model){
                return response()->json([
                    'success' => false,
                    'message' => "Le code cadeau est invalide."
                ]);
            }

            $user = $this->user();
            if($user){
                $exists = $voucher->users()->where('users.id', $user->getKey())->exists();
                if($exists){
                    return response()->json([
                        'success' => false,
                        'message' => "Vous avez déjà utilisé ce code cadeau."
                    ]);
                }

                $exists = $voucher->users()->exists();
                if($exists){
                    return response()->json([
                        'success' => false,
                        'message' => "Ce code cadeau est déjà utilisé."
                    ]);
                }
            }

            $order = new Order();
            $order->currency = 'EUR';
            $order->payment_type = Order::PAYMENT_TYPE_VOUCHER;
            $order->payment_status = Order::PAYMENT_STATUS_PING;
            $order->save();

            $result = false;
            switch (true){
                case $model instanceof Formation:
                    $result = $order->addFormation($model->getKey());
                break;
                case $model instanceof Consultation:
                    $result = $order->addConsultation($model->getKey());
                break;
                case $model instanceof Product:
                    $result = $order->addProduct($model->getKey());
                break;
            }

            if($result){
                $order->checkout(Order::PAYMENT_TYPE_VOUCHER);
                $order->validate();
                $order->pay();

                $voucher->users()->attach($order->user_id);

                if($order->user){
                    $order->user->is_tester = true;
                    $order->user->save();
                }

                return response()->json(['success' => true]);
            }

            $order->delete();
            return response()->json([
                'success' => false,
                'message' => "Ne peut pas activer l'élément correspondant."
            ]);

        } catch (VoucherExpired | VoucherIsInvalid $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }
}
