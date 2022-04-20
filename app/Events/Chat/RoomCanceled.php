<?php

namespace App\Events\Chat;

use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomCanceled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Room
     */
    public $room;

    /**
     * @var string
     */
    public $content;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Room $room, ?string $content, User $user)
    {
        $this->room = $room;
        $this->content = $content;
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
        foreach ($this->room->users as $user) {
            $channels [] = new PrivateChannel('users.' . $user->getKey());
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
        return 'room.canceled';
    }
}
