<?php

namespace App\Http\Requests\Front\Shop;

use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Order;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
        if($this->is('api/v1/experts/*/consultations')){
            return [];
        }

        return [
            'formation_id' => 'required_without_all:product_id,consultation_id|numeric|exists:formations,id',
            'product_id' => 'required_without_all:formation_id,consultation_id|numeric|exists:products,id',
            'consultation_id' => 'required_without_all:formation_id,product_id|numeric|exists:consultations,id',
        ];
    }

    /**
     * Handle request.
     *
     * @param Order $order
     * @param array $data
     * @return Order|null
     * @throws \Exception
     */
    public function handle(Order $order, array $data = array()): ?Order
    {
        $data = array_merge($this->validated(), $data);
        $data['currency'] = 'EUR';
        $data['payment_type'] = Order::PAYMENT_TYPE_BANK_CARD;
        $data['payment_status'] = Order::PAYMENT_STATUS_PING;
        $order->fill($data);
        if($order->save()){
            if(isset($data['formation_id'])){
                $room = Room::where('model_type', '=', Formation::class)
                    ->where('model_id', '=', $data['formation_id'])
                    ->withCount('users')
                    ->first();
                if($room && $room->users_count > 10){
                    throw new \Exception("Il n'y a plus de place disponible pour cette formation.");
                }
                $order->addFormation($data['formation_id']);
            }
            if(isset($data['product_id'])){
                $order->addProduct($data['product_id']);
            }
            if(isset($data['consultation_id'])){
                $order->addConsultation($data['consultation_id']);
            }
            return $order;
        }
        return null;
    }
}
