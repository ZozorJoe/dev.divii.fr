<?php

namespace App\Http\Resources\Front\Catalog;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Front\User\UserResource;
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
 * @property mixed user_id
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
            'created_at' => $this->created_at,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'disciplines' => DisciplineResource::collection($this->whenLoaded('disciplines')),
            'image' => new FileResource($this->whenLoaded('image')),
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
