<?php

namespace App\Listeners\User;

use App\Events\User\UserCreated;
use App\Models\Chat\TimeSlot;
use App\Models\User;
use Carbon\Carbon;

class CreateTimeSlotAfterUserCreated
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        /** @var User $user */
        $user = $event->user;
        if($user){
            $slots = [
                [["08:00:00", "12:00:00"], ["14:00:00", "17:00:00"]],
                [["08:00:00", "12:00:00"], ["14:00:00", "17:00:00"]],
                [["08:00:00", "12:00:00"], ["14:00:00", "17:00:00"]],
                [["08:00:00", "12:00:00"], ["14:00:00", "17:00:00"]],
                [["08:00:00", "12:00:00"], ["14:00:00", "17:00:00"]],
            ];
            foreach ($slots as $index => $items){
                foreach ($items as $item){
                    $start = Carbon::createFromFormat("H:i:s", $item[0])->weekday($index);
                    $end = Carbon::createFromFormat("H:i:s", $item[1])->weekday($index);
                    $user->timeSlots()
                        ->create([
                            'repetition' => TimeSlot::REPETITION_WEEKLY,
                            'start_at' => $start,
                            'end_at' => $end,
                        ]);
                }
            }
        }
    }
}
