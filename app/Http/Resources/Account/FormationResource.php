<?php

namespace App\Http\Resources\Account;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed description
 * @property mixed price
 * @property mixed currency
 * @property mixed vat
 * @property Carbon created_at
 * @property Carbon start_at
 * @property Carbon end_at
 */
class FormationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'currency' => $this->currency,
            'vat' => $this->vat,
            'created_at' => $this->created_at ? $this->created_at->toAtomString() : null,
            'start_at' => $this->start_at ? $this->start_at->toAtomString() : null,
            'end_at' => $this->end_at ? $this->end_at->toAtomString() : null,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
