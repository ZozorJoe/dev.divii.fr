<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\Shop\CartRequest;
use App\Http\Requests\Front\Shop\ConsultationRequest;
use App\Models\Catalog\Discipline;
use App\Models\Shop\Consultation;
use App\Models\Shop\Order;
use App\Models\User\Expert;
use Illuminate\Http\JsonResponse;

class ConsultationController extends ApiController
{
    /**
     * ConsultationController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultationRequest $request
     * @param CartRequest $cartRequest
     * @param Expert $expert
     * @param Discipline $discipline
     * @param Consultation $consultation
     * @param Order $order
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(ConsultationRequest $request, CartRequest $cartRequest, Expert $expert, Discipline $discipline, Consultation $consultation, Order $order): JsonResponse
    {
        $consultation->expert_id = $expert->getKey();
        try {
            $consultation = $request->handle($consultation, $discipline);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        if($consultation){
            $data = [];
            $data['consultation_id'] = $consultation->getKey();
            $order = $cartRequest->handle($order, $data);
            if($order){
                $processed = $request->process($consultation);
                if($processed){
                    $order->payment_type = Order::PAYMENT_TYPE_CREDIT;
                    $order->pay();
                    $order->validate();

                    return response()->json([
                        'success' => true,
                        'order' => $order,
                    ]);
                }else{
                    $order->delete();

                    return response()->json([
                        'success' => false,
                        'consultation' => $consultation,
                        'message' => 'Vous n\'avez pas assez de crédit pour payer cette consultation.'
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Oups, votre consultant n’est pas disponible pour pour cette durée. Veuillez essayer un autre créneau'
        ]);
    }
}
