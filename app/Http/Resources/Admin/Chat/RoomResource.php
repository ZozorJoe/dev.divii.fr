<?php

namespace App\Http\Resources\Admin\Chat;

use App\Http\Resources\Admin\Catalog\FormationResource;
use App\Http\Resources\Admin\Shop\ConsultationResource;
use App\Http\Resources\Admin\User\CustomerResource;
use App\Http\Resources\Admin\User\ExpertResource;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\Catalog\Formation;
use App\Models\Shop\Consultation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property Carbon start_at
 * @property Carbon end_at
 * @property Carbon created_at
 * @property Model model
 * @property mixed status
 */
class RoomResource extends JsonResource
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
            'status' => $this->status,
            'title' => $this->title,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at,
            'expert' => new ExpertResource($this->whenLoaded('expert')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'customers' => CustomerResource::collection($this->whenLoaded('customers')),
        ];

        if($this->whenLoaded('model')){
            $model = $this->resource->model;
            switch (true){
                case $model instanceof Consultation:
                    $model->load('discipline');
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
    public function with($request): array
    {
        return [
            'success' => true,
        ];
    }
}
