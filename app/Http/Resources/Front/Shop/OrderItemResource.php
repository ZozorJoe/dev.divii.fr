<?php

namespace App\Http\Resources\Front\Shop;

use App\Http\Resources\Front\Catalog\FormationResource;
use App\Http\Resources\Front\Catalog\ProductResource;
use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Shop\Consultation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = parent::toArray($request);

        $orderable = $this->resource->orderable;
        switch (true){
            case $orderable instanceof Product:
                unset($data['orderable']);
                $data['product'] = new ProductResource($orderable);
            break;
            case $orderable instanceof Consultation:
                $orderable->load('expert');
                $data['consultation'] = new ConsultationResource($orderable);
            break;
            case $orderable instanceof Formation:
                $data['formation'] = new FormationResource($orderable);
            break;
        }

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
