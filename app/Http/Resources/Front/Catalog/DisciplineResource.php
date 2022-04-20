<?php

namespace App\Http\Resources\Front\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed description
 * @property mixed is_active
 * @property int users_count
 * @property mixed background_color
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
            $this->mergeWhen(isset($this->users_count), [
                'users_count' => $this->users_count
            ])
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
