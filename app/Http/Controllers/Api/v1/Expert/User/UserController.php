<?php

namespace App\Http\Controllers\Api\v1\Expert\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Expert\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function show(Request $request, User $user): UserResource
    {
        $this->with($request, $user);

        return new UserResource($user);
    }
}
