<?php

namespace App\Events\Chat;

use App\Models\Chat\Message;
use App\Models\Chat\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Signal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $message;

    /**
     * @var Room
     */
    protected $room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Room $room, $message)
    {
        $this->room = $room;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        if ($room = $this->room) {
            if(isset($this->message['dest'])){
                $channels[] = new PrivateChannel('rooms.' . $room->getKey(). '.' . $this->message['dest']);
            }else{
                $channels[] = new PrivateChannel('rooms.' . $room->getKey());
            }
        }
        return $channels;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'signal';
    }

    /**
     * The event's broadcast content.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return $this->message;
    }
}
