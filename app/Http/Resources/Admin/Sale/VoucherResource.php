<?php

namespace App\Http\Resources\Admin\Sale;

use App\Http\Resources\Admin\User\UserResource;
use App\Http\Resources\Expert\Catalog\FormationResource;
use App\Http\Resources\Expert\Catalog\ProductResource;
use App\Http\Resources\Expert\Shop\ConsultationResource;
use App\Http\Resources\File\FileResource;
use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Shop\Consultation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed code
 * @property Carbon created_at
 */
class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'code' => $this->code,
            'created_at' => $this->created_at,
        ];

        $loaded = $this->whenLoaded('model');
        if($loaded){
            $model = $this->resource->model;
            switch (true){
                case $model instanceof Product:
                    $data['product'] = new ProductResource($model);
                break;
                case $model instanceof Formation:
                    $data['formation'] = new FormationResource($model);
                break;
                case $model instanceof Consultation:
                    $data['consultation'] = new ConsultationResource($model);
                break;
                default:
                    $data['model'] = $model;
                break;
            }
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
