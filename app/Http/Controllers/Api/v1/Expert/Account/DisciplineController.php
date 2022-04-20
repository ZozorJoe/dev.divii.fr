<?php

namespace App\Http\Controllers\Api\v1\Expert\Account;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Expert\Account\DisciplineRequest;
use App\Http\Resources\Expert\Account\AccountResource;
use Illuminate\Http\JsonResponse;

class DisciplineController extends ApiController
{
    /**
     * Update the specified resource in storage.
     *
     * @param DisciplineRequest $request
     * @return AccountResource|JsonResponse
     */
    public function update(DisciplineRequest $request)
    {
        $user = $request->user();
        $expert = $request->handle($user);
        if($expert){
            $expert->load('disciplines');

            return new AccountResource($expert);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
