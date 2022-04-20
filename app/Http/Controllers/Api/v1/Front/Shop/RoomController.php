<?php

namespace App\Http\Controllers\Api\v1\Front\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\Shop\RoomRequest;
use App\Models\Chat\Room;
use App\Models\User\Expert;
use Illuminate\Http\JsonResponse;

class RoomController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomRequest $request
     * @param Expert $expert
     * @param Room $room
     * @return JsonResponse
     */
    public function store(RoomRequest $request, Expert $expert, Room $room): JsonResponse
    {
        $user = $request->user();

        $room = $request->handle($room);
        if($room){
            $room->users()->attach($expert->getKey());
            $room->users()->attach($user->getKey());

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

}
