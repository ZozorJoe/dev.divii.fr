<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Events\Auth\Registered;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
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
            'birthday' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_hour' => 'required|string|max:255',
            'phone' => 'nullable|max:15',
            'code' => 'nullable|max:10',
            'password' => 'required|string|confirmed|min:8',
            'agree' => 'accepted',
        ]);

        $user = User::where('email', '=', $data['email'])->first();
        if($user){
            if($user->channel !== User::CHANNEL_LAUNCH){
                $request->validate([
                    'email' => 'unique:users,email',
                ]);
                return response()->json([
                    'success' => false,
                ]);
            }
        }else{
            $user = new User();
        }

        if(!empty($data['code'])){
            $main = User::where('code', '=', $data['code'])->first();
            if($main){
                $data['main_id'] = $main->getKey();
            }
        }

        $user->fill([
            'channel' => User::CHANNEL_REGISTRATION,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'birth_hour' => $data['birth_hour'],
            'birth_place' => $data['birth_place'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'main_id' => $data['main_id'] ?? null,
        ]);
        if($user->save()){
            event(new Registered($user));

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
