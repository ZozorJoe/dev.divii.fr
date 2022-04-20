<?php

namespace App\Http\Resources\Account;

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
 * @property mixed avatar_id
 * @property mixed role
 * @property Carbon birthday
 * @property mixed rib
 * @property mixed arc
 * @property mixed credit
 * @property mixed is_tester
 * @property mixed has_new_message
 */
class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday ? $this->birthday->format('Y-m-d') : null ,
            'email' => $this->email,
            'role' => $this->role,
            'rib' => $this->rib,
            'arc' => $this->arc,
            'credit' => (int) $this->credit,
            'is_tester' => (boolean) $this->is_tester,
            'has_new_message' => (boolean) $this->has_new_message,
            'avatar' => new FileResource($this->whenLoaded('avatar')),
            $this->mergeWhen(!$this->whenLoaded('avatar'), [
                'avatar_url' => $this->avatar_url,
            ]),
        ];
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
