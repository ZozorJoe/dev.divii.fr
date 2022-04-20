<?php

namespace App\Http\Controllers\Api\v1\Account;

use App\Events\Account\AccountUpdated;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Account\AccountRequest;
use App\Http\Resources\Account\AccountResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return new AccountResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountRequest $request
     * @return AccountResource|JsonResponse
     */
    public function update(AccountRequest $request)
    {
        $data = $request->all();
        if(empty($data['password'])){
            $password = null;
            unset($data['password']);
        }else{
            $password = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }

        /** @var User $user */
        $user = $request->user();
        if($user->update($data)){
            $user->refresh();
            $user->load('avatar');
            event(new AccountUpdated($user, $password));
            return new AccountResource($user);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
