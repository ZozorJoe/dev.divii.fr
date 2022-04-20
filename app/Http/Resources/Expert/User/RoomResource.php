<?php

namespace App\Http\Resources\Expert\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed user_id
 * @property Carbon start_at
 * @property Carbon end_at
 * @property Carbon updated_at
 */
class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'user_id' => $this->user_id,
        ];

        return $data;
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
