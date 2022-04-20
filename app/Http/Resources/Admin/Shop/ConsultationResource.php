<?php

namespace App\Http\Resources\Admin\Shop;

use App\Http\Resources\Admin\Catalog\DisciplineResource;
use App\Http\Resources\Admin\User\CustomerResource;
use App\Http\Resources\Admin\User\ExpertResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed status
 * @property mixed name
 * @property Carbon start_at
 * @property Carbon end_at
 */
class ConsultationResource extends JsonResource
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
            'status' => $this->status,
            'name' => $this->name,
            'start_at' => $this->start_at ? $this->start_at->toAtomString() : null,
            'end_at' => $this->end_at ? $this->end_at->toAtomString() : null,
            'discipline' => new DisciplineResource($this->whenLoaded('discipline')),
            'expert' => new ExpertResource($this->whenLoaded('expert')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'main' => new ConsultationResource($this->whenLoaded('main')),
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
