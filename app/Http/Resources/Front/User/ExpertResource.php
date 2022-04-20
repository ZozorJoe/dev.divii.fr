<?php

namespace App\Http\Resources\Front\User;

use App\Http\Resources\Front\Catalog\DisciplineResource;
use App\Http\Resources\Front\Catalog\FormationResource;
use Illuminate\Http\Request;

/**
 * @property mixed description
 * @property mixed available
 * @property mixed background_color
 */
class ExpertResource extends UserResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = parent::toArray($request);
        $data['available'] = $this->available;
        $data['online'] = (bool) $this->online;
        $data['description'] = $this->description;
        $data['background_color'] = $this->background_color;
        $data['disciplines'] = DisciplineResource::collection($this->whenLoaded('disciplines'));
        $data['formations'] = FormationResource::collection($this->whenLoaded('formations'));
        return $data;
    }
}
