<?php

namespace App\Events\Chat;

use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Room
     */
    public $room;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Room $room, User $user)
    {
        $this->room = $room;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): array
    {
        $channels = [];
        if($this->user){
            $channels [] = new PrivateChannel('users.' . $this->user->getKey());
        }else{
            foreach ($this->room->users as $user) {
                $channels [] = new PrivateChannel('users.' . $user->getKey());
            }
        }
        return $channels;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'room.created';
    }
}
