<?php

namespace App\Http\Controllers\Web\Account;

use App\Http\Controllers\Web\WebController;
use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends WebController
{
    public function index(Request $request)
    {
        return view('app');
    }

    public function show(Request $request, Room $room)
    {
        /** @var User $user */
        $user = $request->user();
        $canJoin = $user->canJoin($room->getKey());
        if(!$canJoin){
            abort(403);
        }
        return view('app');
    }
}
