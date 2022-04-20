<?php

namespace App\Http\Resources\Admin\Sale;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed type
 * @property mixed name
 * @property mixed active
 * @property Carbon start_date
 * @property Carbon end_date
 * @property mixed value
 */
class CouponResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'value' => $this->value,
            'active' => (boolean) $this->active,
            'start_date' => $this->start_date ? $this->start_date->format('Y-m-d') : null,
            'end_date' => $this->end_date ? $this->end_date->format('Y-m-d') : null,
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
