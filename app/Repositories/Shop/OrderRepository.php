<?php

namespace App\Repositories\Shop;

use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Services\PayPal;
use App\Services\Sogecom;
use Illuminate\Http\JsonResponse;
use Omnipay\Omnipay;

class OrderRepository
{
    /**
     * @var Order
     */
     protected $model;

    /**
     * OrderRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * @return Order
     */
    public function getModel(): Order
    {
        return $this->model;
    }

    /**
     * @param Order $model
     * @return OrderRepository
     */
    public function setModel(Order $model): OrderRepository
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return JsonResponse
     */
    public function payPerFree(): JsonResponse
    {
        $order = $this->getModel();

        if($order->total > 0){
            return response()->json([
                'success' => false,
                'message' => "Vous devez encore payer $order->total $order->currency!",
            ]);
        }

        $order->checkout(Order::PAYMENT_TYPE_FREE);
        $order->validate();
        $order->pay();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function payPerCash(): JsonResponse
    {
        $order = $this->getModel();

        $order->checkout(Order::PAYMENT_TYPE_CASH);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function payPerBankTransfer(): JsonResponse
    {
        $order = $this->getModel();

        $order->checkout(Order::PAYMENT_TYPE_BANK_TRANSFER);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function payPerStripe($token): JsonResponse
    {
        $order = $this->getModel();

        $order->checkout(Order::PAYMENT_TYPE_STRIPE);

        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey(config('gateway.stripe.key.secret'));

        $total = $order->total;
        $currency = $order->currency;

        $response = $gateway->purchase([
            'amount' => $total,
            'currency' => $currency,
            'token' => $token,
        ])->send();

        // Process response
        if ($response->isSuccessful()) {
            // Payment was successful
            $order->validate();

            return response()->json([
                'success' => true,
            ]);
        }

        // Redirect to offsite payment gateway
        if ($response->isRedirect()) {
            return $response->redirect();
        }

        // Payment error
        return response()->json([
            'success' => false,
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function payPerPayPal(): JsonResponse
    {
        $order = $this->getModel();

        $order->checkout(Order::PAYMENT_TYPE_PAYPAL);

        $paypal = new PayPal();

        $response = $paypal->purchase([
            'amount' => $paypal->formatAmount($order->total),
            'transactionId' => $order->getKey(),
            'currency' => $order->currency,
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
            'notifyUrl' => $paypal->getNotifyUrl($order),
        ]);

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return response()->json([
            'success' => true,
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function payPerBankCard(): JsonResponse
    {
        $order = $this->getModel();

        $payment = $order->checkout(Payment::TYPE_BANK_CARD);

        $service = new Sogecom();
        $params = $service->getParams($payment);

        $form = view('front.checkout.form', [
            'params' => $params,
        ])->render();

        return response()->json([
            'success' => true,
            'form' => $form,
            'message' => 'OK',
        ]);
    }
}
