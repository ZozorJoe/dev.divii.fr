<?php

namespace App\Http\Requests\Front\Shop;

use App\Models\Shop\Order;
use App\Repositories\Shop\OrderRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class CheckoutRequest extends FormRequest
{
    /**
     * @var OrderRepository
     */
    private $repository;

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
            'method' => 'required|string',
        ];
    }

    /**
     * Handle request.
     *
     * @param Order $order
     * @param array $data
     * @return JsonResponse
     */
    public function handle(Order $order, array $data = array()): JsonResponse
    {
        $this->repository->setModel($order);

        $data = array_merge($this->validated(), $data);
        switch($data['method']){
            case Order::PAYMENT_TYPE_FREE:
                return $this->repository->payPerFree();
            case Order::PAYMENT_TYPE_CASH:
                return $this->repository->payPerCash();
            case Order::PAYMENT_TYPE_BANK_TRANSFER:
                return $this->repository->payPerBankTransfer();
            case Order::PAYMENT_TYPE_BANK_CARD:
                return $this->repository->payPerBankCard();
            case Order::PAYMENT_TYPE_PAYPAL:
                return $this->repository->payPerPayPal();
            case Order::PAYMENT_TYPE_STRIPE:
                $token = $this->get('token');
                return $this->repository->payPerStripe($token);
        }

        return response()->json(['success' => false]);
    }

    /**
     * @param OrderRepository $orderRepository
     */
    public function setOrderRepository(OrderRepository $orderRepository)
    {
        $this->repository = $orderRepository;
    }
}
