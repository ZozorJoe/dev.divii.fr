<?php

namespace App\Http\Resources\Account;

use App\Http\Resources\Admin\User\CustomerResource;
use App\Http\Resources\Admin\User\ExpertResource;
use App\Http\Resources\Front\Catalog\DurationResource;
use App\Http\Resources\Front\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed status
 * @property mixed name
 * @property Carbon start_at
 * @property Carbon end_at
 * @property mixed customer_id
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
            'customer_id' => $this->customer_id,
            'customer' => new UserResource($this->whenLoaded('customer')),
            'duration' => new DurationResource($this->whenLoaded('duration')),
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
