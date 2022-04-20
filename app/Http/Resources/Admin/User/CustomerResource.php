<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;

/**
 * @property mixed credit
 * @property mixed is_tester
 */
class CustomerResource extends UserResource
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
        $data['credit'] = $this->credit;
        $data['is_tester'] = (boolean) $this->is_tester;
        return $data;
    }
}
