<?php

namespace App\Http\Controllers\Api\v1\Account;

use App\Http\Controllers\Api\ApiController;
use App\Models\Chat\Room;
use App\Models\User;
use App\Models\User\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Room $room
     * @return JsonResponse
     */
    public function store(Request $request, Room $room): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $builder = Rating::query();
        $builder->where('user_id', $user->getKey());
        $builder->where('room_id', $room->getKey());
        $exists = $builder->exists();
        if($exists){
            return response()->json([
               'success' => false,
            ]);
        }

        $rating = new Rating();
        $rating->user_id = $user->getKey();
        $rating->expert_id = $room->user_id;
        $rating->room_id = $room->getKey();
        $rating->value = $request->get('value');
        $rating->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
