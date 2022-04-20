<?php

namespace App\Http\Resources\Admin\Zodiac;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed status
 * @property Carbon created_at
 * @property mixed belier
 * @property mixed taureau
 * @property mixed gemeaux
 * @property mixed cancer
 * @property mixed lion
 * @property mixed vierge
 * @property mixed balance
 * @property mixed scorpion
 * @property mixed sagittaire
 * @property mixed capricorne
 * @property mixed verseau
 * @property mixed poissons
 */
class HoroscopeResource extends JsonResource
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
            'belier' => $this->belier,
            'taureau' => $this->taureau,
            'gemeaux' => $this->gemeaux,
            'cancer' => $this->cancer,
            'lion' => $this->lion,
            'vierge' => $this->vierge,
            'balance' => $this->balance,
            'scorpion' => $this->scorpion,
            'sagittaire' => $this->sagittaire,
            'capricorne' => $this->capricorne,
            'verseau' => $this->verseau,
            'poissons' => $this->poissons,
            'created_at' => $this->created_at,
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
