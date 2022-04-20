<?php

namespace App\Http\Resources\Admin\Shop;

use App\Http\Resources\Admin\Catalog\FormationResource;
use App\Http\Resources\Admin\Catalog\ProductResource;
use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Shop\Consultation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed order_id
 * @property mixed price
 * @property mixed quantity
 * @property mixed sub_total
 * @property mixed vat
 * @property mixed vat_total
 * @property mixed row_total
 * @property mixed currency
 */
class OrderItemResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sub_total' => $this->sub_total,
            'vat' => $this->vat,
            'vat_total' => $this->vat_total,
            'row_total' => $this->row_total,
            'currency' => $this->currency,
        ];

        if($this->whenLoaded('orderable')){
            $orderable = $this->resource->orderable;
            switch (true){
                case $orderable instanceof Product:
                    $data['product'] = new ProductResource($orderable);
                    break;
                case $orderable instanceof Formation:
                    $data['formation'] = new FormationResource($orderable);
                    break;
                case $orderable instanceof Consultation:
                    $data['consultation'] = new ConsultationResource($orderable);
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
