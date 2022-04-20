<?php

namespace App\Listeners\Chat;

use App\Events\Chat\RoomCreated;
use App\Jobs\Room\Reminder;

class DispatchReminderNotification
{
    /**
     * Handle the event.
     *
     * @param RoomCreated $event
     * @return void
     */
    public function handle(RoomCreated $event)
    {
        $times = [24 * 3600, 30];
        foreach ($times as $time){
            $delay = $event->room
                    ->start_at
                    ->subMinutes($time);
            Reminder::dispatch($event->room, $event->user, $time)
                ->delay($delay);
        }
    }
}
