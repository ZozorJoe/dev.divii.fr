<?php

namespace App\Http\Controllers\Api\v1\Expert\Account;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Expert\Account\AccountResource;
use Illuminate\Http\Request;

class AccountController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AccountResource
     */
    public function show(Request $request): AccountResource
    {
        $user = $request->user();

        $user->load('avatar');
        $user->load('disciplines');

        return new AccountResource($user);
    }
}
