<?php

namespace App\Events\Chat;

use App\Models\Chat\Room;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Room
     */
    public $room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Room $room)
    {
        $this->room = $room;
    }
}
