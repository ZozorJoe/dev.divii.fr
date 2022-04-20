<?php

namespace App\Http\Requests\Front\Shop;

use App\Models\Shop\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'formation_id' => 'numeric|exists:formations,id',
        ];
    }

    /**
     * Handle request.
     *
     * @param Order $order
     * @param array $data
     * @return Order|null
     */
    public function handle(Order $order, array $data = array()): ?Order
    {
        $data = array_merge($this->validated(), $data);
        $order->fill($data);
        if($order->save()){
            return $order;
        }
        return null;
    }
}
