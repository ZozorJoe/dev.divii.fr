<?php

namespace App\Services;

use App\Models\Shop\Order;
use Omnipay\Omnipay;

class PayPal
{
    /**
     * @return mixed
     */
    public function gateway()
    {
        $gateway = Omnipay::create('PayPal_Express');

        $gateway->setTestMode(config('gateway.paypal.mode') === 'sandbox');
        if($gateway->getTestMode()){
            $gateway->setUsername(config('gateway.paypal.sandbox.username'));
            $gateway->setPassword(config('gateway.paypal.sandbox.password'));
            $gateway->setSignature(config('gateway.paypal.sandbox.signature'));
        }else{
            $gateway->setUsername(config('gateway.paypal.live.username'));
            $gateway->setPassword(config('gateway.paypal.live.password'));
            $gateway->setSignature(config('gateway.paypal.live.signature'));
        }

        return $gateway;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function purchase(array $parameters)
    {
        return $this->gateway()
            ->purchase($parameters)
            ->send();
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function complete(array $parameters)
    {
        return $this->gateway()
            ->completePurchase($parameters)
            ->send();
    }

    /**
     * @param $amount
     * @return string
     */
    public function formatAmount($amount): string
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param Order $order
     * @return string
     */
    public function getCancelUrl(Order $order): string
    {
        return route('front.orders.cancel', [
            'order' => $order,
        ]);
    }

    /**
     * @param Order $order
     * @return string
     */
    public function getReturnUrl(Order $order): string
    {
        return route('front.orders.complete', [
            'order' => $order,
        ]);
    }

    /**
     * @param Order $order
     * @return string
     */
    public function getNotifyUrl(Order $order): string
    {
        $env = config('gateway.paypal.mode');

        return route('webhook.paypal', [
            'order' => $order,
            'env' => $env
        ]);
    }
}
