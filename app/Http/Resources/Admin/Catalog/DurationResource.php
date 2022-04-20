<?php

namespace App\Http\Resources\Admin\Catalog;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed label
 * @property mixed credit
 * @property mixed price
 * @property mixed currency
 * @property mixed vat
 * @property mixed delay
 * @property Carbon created_at
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
            'label' => $this->label,
            'credit' => $this->credit,
            'price' => $this->price,
            'currency' => $this->currency,
            'vat' => $this->vat,
            'delay' => $this->delay,
            'created_at' => $this->created_at,
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
