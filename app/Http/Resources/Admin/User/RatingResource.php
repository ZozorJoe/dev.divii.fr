<?php

namespace App\Http\Resources\Admin\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed value
 * @property mixed status
 * @property Carbon created_at
 */
class RatingResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'value' => $this->value,
            'created_at' => $this->created_at->toAtomString(),
            'expert' => new UserResource($this->whenLoaded('expert')),
            'user' => new UserResource($this->whenLoaded('user')),
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
