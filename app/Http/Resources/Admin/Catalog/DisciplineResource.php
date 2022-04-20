<?php

namespace App\Http\Resources\Admin\Catalog;

use App\Http\Resources\File\FileResource;
use App\Models\User\DisciplineUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed description
 * @property mixed is_active
 * @property Carbon created_at
 * @property mixed image_url
 * @property mixed background_color
 * @property DisciplineUser pivot
 */
class DisciplineResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'background_color' => $this->background_color,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at,
            'durations' => $this->pivot ? $this->pivot->durations : null,
            'with_preparation' => $this->pivot ? $this->pivot->with_preparation : false,
            'image' => new FileResource($this->whenLoaded('image')),
            'picto' => new FileResource($this->whenLoaded('picto')),
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
