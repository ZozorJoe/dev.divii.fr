<?php

namespace App\Http\Resources\Admin\Shop;

use App\Http\Resources\Admin\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $reference
 * @property mixed $total
 * @property mixed $vat_total
 * @property mixed $sub_total
 * @property mixed $currency
 * @property mixed $payment_type
 * @property mixed $payment_status
 */
class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'sub_total' => $this->sub_total,
            'vat_total' => $this->vat_total,
            'total' => $this->total,
            'currency' => $this->currency,
            'payment_type' => $this->payment_type,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'items' => InvoiceItemResource::collection($this->whenLoaded('items')),
            'user' => new UserResource($this->whenLoaded('user')),
            'order' => new OrderResource($this->whenLoaded('order')),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  Request  $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'success' => true,
        ];
    }
}
