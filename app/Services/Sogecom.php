<?php

namespace App\Services;

use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use Exception;

class Sogecom
{

    /**
     * @param Payment $payment
     * @return array
     */
    public function getParams(Payment $payment): array
    {
        // Config
        $mode = strtolower(config('gateway.sogecom.mode'));
        $site_id = config('gateway.sogecom.'.$mode.'.site_id');
        $key = config('gateway.sogecom.'.$mode.'.key');

        $params = [
            // Required
            'vads_action_mode' => 'INTERACTIVE',
            'vads_amount' => (int) ($payment->amount * 100),
            'vads_ctx_mode' => strtoupper($mode),
            'vads_currency' => 978, // EUR
            'vads_page_action' => 'PAYMENT',
            'vads_payment_config' => 'SINGLE',
            'vads_site_id' => $site_id,
            'vads_trans_date' => $payment->created_at->format('YmdHis'),
            'vads_trans_id' => str_pad($payment->getKey(), 6, '0', STR_PAD_LEFT),
            'vads_version' => 'V2',

            // Optionnal
            'vads_order_id' => $payment->order_id,
        ];

        $params['signature'] = $this->getSignature($params, $key);

        return $params;
    }

    public function getSignature($params, $key): string
    {
        /**
         * Fonction qui calcule la signature.
         * $params : tableau contenant les champs à envoyer dans le formulaire.
         * $key : clé de TEST ou de PRODUCTION
         */
        //Initialisation de la variable qui contiendra la chaine à chiffrer
        $contenu_signature = "";

        //Tri des champs par ordre alphabétique
        ksort($params);
        foreach($params as $nom=>$valeur){
            //Récupération des champs vads_
            if (substr($nom,0,5)=='vads_'){
                //Concaténation avec le séparateur "+"
                $contenu_signature .= $valeur."+";
            }
        }
        //Ajout de la clé en fin de chaine
        $contenu_signature .= $key;

        //Encodage base64 de la chaine chiffrée avec l'algorithme HMAC-SHA-256
        return base64_encode(hash_hmac('sha256',$contenu_signature, $key, true));
    }

    /**
     * @throws Exception
     */
    public function handleIpn(array $data)
    {
        //Signature computation
        info('IPN: Signature computation');
        $mode = strtolower(config('gateway.sogecom.mode'));
        $key = config('gateway.sogecom.'.$mode.'.key');
        $sign = $this->getSignature($data, $key);

        //Signature verification
        if ($_POST['signature'] == $sign){
            // Processing data
            info('IPN: Processing data');

            /** @var Payment $payment */
            $payment = $this->getPayment($data['vads_trans_id']);
            if($payment){
                info("IPN: Payment " . $payment->getKey() . " found");
                $order = $payment->order;
                if($order){
                    info("IPN: Order " . $order->getKey() . " found with status " . $order->status);
                    switch ($order->status){
                        case Order::STATUS_COMPLETE:
                            throw new Exception('Order already complete');
                        case Order::STATUS_CANCELED:
                            throw new Exception('Order already canceled');
                    }

                    switch ($data['vads_trans_status']){
                        // La transaction n’est pas créée et n’est donc pas visible dans le Back Office Marchand.
                        case 'ABANDONED':
                        // Les transactions dont le statut est "ACCEPTED" ne sont jamais remises en banque.
                        case 'ACCEPTED':
                        // La transaction est annulée par le marchand.
                        case 'CANCELLED':
                        // La remise de la transaction a échoué.
                        case 'CAPTURE_FAILED':
                        // La remise de la transaction a expiré.
                        case 'EXPIRED':
                            $order->payment_status = Order::PAYMENT_STATUS_CANCELED;
                            $order->cancel();

                            $payment->status = Payment::STATUS_CANCELED;
                            $payment->save();
                        break;

                        // La transaction est acceptée et sera remise en banque automatiquement à la date prévue.
                        case 'AUTHORISED':
                            $payment->status = Payment::STATUS_AUTHORIZED;
                            $payment->save();
                        break;

                        // La transaction est remise en banque.
                        case 'CAPTURED':
                            $amount = (int) ($payment->amount * 100);
                            $currency = 978;
                            if($amount === $data['vads_amount'] && $currency === $data['vads_currency']){
                                info("IPN: Amount and currency is same.");

                                $order->validate();
                                $order->pay();

                                $payment->trans_uuid = $data['vads_trans_uuid'] ?? null;
                                $payment->status = Payment::STATUS_CAPTURED;
                                $payment->save();
                            }else{
                                error_log("IPN: Amount or currency not same [$amount != {$data['vads_amount']} OR [$currency != {$data['vads_currency']}]");
                            }
                        break;

                        // La remise de la transaction est temporairement bloquée.
                        case 'SUSPENDED':
                        // En attente de la réponse de l'acquéreur.
                        case 'UNDER_VERIFICATION':
                        // En attente d'autorisation
                        case 'WAITING_AUTHORISATION':
                        // A valider et autoriser
                        case 'WAITING_AUTHORISATION_TO_VALIDATE':
                            // Do nothing
                        break;
                    }

                }else{
                    error_log("IPN: No order found");
                }
            }else{
                error_log("IPN: No payment found");
            }
        }else{
            error_log('IPN: An error occurred while computing the signature');
            throw new Exception('An error occurred while computing the signature');
        }
    }

    /**
     * @param $trans_id
     * @return mixed
     */
    private function getPayment($trans_id)
    {
        return Payment::where('trans_id', '=', $trans_id)
            ->first();
    }
}
