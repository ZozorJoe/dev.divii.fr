<?php

namespace App\Listeners\Chat;

use App\Events\Chat\RoomCreated;

class SendRoomCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param RoomCreated $event
     * @return void
     */
    public function handle(RoomCreated $event)
    {
        $room = $event->room;
        $user = $event->user;
        if($room && $user){
            $user->notify(new \App\Notifications\Room\RoomCreated($room));
        }

    }
}
