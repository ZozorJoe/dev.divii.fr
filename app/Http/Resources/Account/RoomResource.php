<?php

namespace App\Http\Resources\Account;

use App\Http\Resources\Account\User\UserResource;
use App\Models\Catalog\Formation;
use App\Models\Shop\Consultation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed user_id
 * @property Carbon start_at
 * @property Carbon end_at
 * @property Carbon updated_at
 */
class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'start_at' => $this->start_at,
            'updated_at' => $this->updated_at,
            'end_at' => $this->end_at,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'latestMessage' => new MessageResource($this->whenLoaded('latestMessage')),
        ];

        if($this->whenLoaded('model')){
            $model = $this->resource->model;
            switch (true){
                case $model instanceof Consultation:
                    $model->load('customer');
                    $model->load('duration');
                    $data['consultation'] = new ConsultationResource($model);
                    break;
                case $model instanceof Formation:
                    $data['formation'] = new FormationResource($model);
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
