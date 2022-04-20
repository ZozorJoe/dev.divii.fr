<?php

namespace App\Listeners\Room;

use App\Events\Chat\RoomCanceled;
use App\Models\User;

class SendRoomCanceledNotification
{
    /**
     * Handle the event.
     *
     * @param  RoomCanceled  $event
     * @return void
     */
    public function handle(RoomCanceled $event)
    {
        $room = $event->room;
        $content = $event->content;
        $user = $event->user;
        $expert = $room->user;
        if($room->isAdmin($user) || $room->isExpert($user)){
            /** @var User[] $customers */
            $customers = $room->customers()->get();
            foreach ($customers as $customer){
                $customer->notify(new \App\Notifications\Room\RoomCanceled($room, $content));
            }
        }else{
            $expert->notify(new \App\Notifications\Room\RoomCanceled($room, $content));
            $user->notify(new \App\Notifications\Room\RoomCanceled($room, $content));
        }


    }
}
