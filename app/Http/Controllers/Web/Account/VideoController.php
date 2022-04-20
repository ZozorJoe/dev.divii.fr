<?php

namespace App\Http\Controllers\Web\Account;

use App\Http\Controllers\Web\WebController;
use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Http\Request;

class VideoController extends WebController
{
    public function show(Request $request, Room $room)
    {
        if(in_array($room->status, [Room::STATUS_CANCELED])){
            abort(403);
        }

        if($room->end_at && $room->end_at->isBefore(now()->subWeek())){
            abort(404);
        }

        /** @var User $user */
        $user = $request->user();
        $canJoin = $user->canJoin($room->getKey());
        if(!$canJoin){
            abort(403);
        }

        return view('app');
    }
}
