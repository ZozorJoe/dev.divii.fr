<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends ApiController
{
    /**
     * Handle an reset password.
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function store(ResetPasswordRequest $request): JsonResponse
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        $success = !in_array($status, ['passwords.throttled']);

        if($success){
            return response()->json([
                'success' => true,
                'data' => [
                    'status' => 'passwords.sent',
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => [
                'status' => 'passwords.throttled',
            ],
        ], 400);
    }
}
