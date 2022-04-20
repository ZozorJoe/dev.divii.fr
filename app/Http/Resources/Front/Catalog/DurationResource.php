<?php

namespace App\Http\Resources\Front\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed label
 * @property mixed price
 * @property mixed vat
 * @property mixed currency
 * @property mixed credit
 */
class DurationResource extends JsonResource
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
            'credit' => $this->credit,
            'label' => $this->label,
            'price' => $this->price,
            'vat' => $this->vat,
            'currency' => $this->currency,
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
