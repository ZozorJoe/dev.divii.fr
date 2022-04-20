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
 * @property mixed invoice_id
 * @property mixed price
 * @property mixed quantity
 * @property mixed sub_total
 * @property mixed vat
 * @property mixed vat_total
 * @property mixed row_total
 * @property mixed currency
 */
class InvoiceItemResource extends JsonResource
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
            'invoice_id' => $this->invoice_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sub_total' => $this->sub_total,
            'vat' => $this->vat,
            'vat_total' => $this->vat_total,
            'row_total' => $this->row_total,
            'currency' => $this->currency,
            'orderItem' => new OrderItemResource($this->whenLoaded('orderItem')),
        ];

        if($this->whenLoaded('invoiceable')){
            $invoiceable = $this->resource->invoiceable;
            switch (true){
                case $invoiceable instanceof Product:
                    $data['product'] = new ProductResource($invoiceable);
                    break;
                case $invoiceable instanceof Formation:
                    $data['formation'] = new FormationResource($invoiceable);
                    break;
                case $invoiceable instanceof Consultation:
                    $data['consultation'] = new ConsultationResource($invoiceable);
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
