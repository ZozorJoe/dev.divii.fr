<?php

namespace App\Http\Resources\Expert\Catalog;

use App\Http\Resources\Expert\User\UserResource;
use App\Http\Resources\File\FileResource;
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
 * @property mixed user_id
 * @property Carbon start_at
 * @property Carbon end_at
 * @property mixed image_url
 * @property mixed background_color
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
            'duration' => $this->end_at && $this->start_at ? $this->start_at->diffInHours($this->end_at) : null,
            'user_id' => $this->user_id,
            'background_color' => $this->background_color,
            'user' => new UserResource($this->whenLoaded('user')),
            'disciplines' => DisciplineResource::collection($this->whenLoaded('disciplines')),
            'image' => new FileResource($this->whenLoaded('image')),
            'picto' => new FileResource($this->whenLoaded('picto')),
            $this->mergeWhen(!$this->whenLoaded('image'), [
                'image_url' => $this->image_url,
            ]),
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
