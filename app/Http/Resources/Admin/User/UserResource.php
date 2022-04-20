<?php

namespace App\Http\Resources\Admin\User;

use App\Http\Resources\File\FileResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed avatar_url
 * @property Carbon created_at
 * @property mixed online
 * @property mixed role
 * @property mixed status
 * @property Carbon birthday
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday ? $this->birthday->format('Y-m-d') : null,
            'email' => $this->email,
            'role' => $this->role,
            'online' => (bool) $this->online,
            'created_at' => $this->created_at,
            'avatar' => new FileResource($this->whenLoaded('avatar')),
            $this->mergeWhen(isset($this->status), ['status' => (bool) $this->status]),
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
