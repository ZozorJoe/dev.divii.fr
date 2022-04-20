<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Events\Sale\CouponCreated;
use App\Events\User\UserCreated;
use App\Events\User\UserWelcome;
use App\Facades\Coupons;
use App\Facades\Password;
use App\Http\Controllers\Api\ApiController;
use App\Models\Sale\Coupon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends ApiController
{
    /**
     * Handle an registration attempt.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', '=', $data['email'])->first();
        if($user){
            return response()->json([
                'success' => false,
                'message' => "Vous avez déjà souscrit avec cette adresse email."
            ]);
        }

        $data['channel'] = User::CHANNEL_LAUNCH;
        $data['password'] = Password::generate();

        $user = User::create([
            'channel' => $data['channel'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new UserWelcome($user));

        return response()->json(['success' => true]);
    }
}
