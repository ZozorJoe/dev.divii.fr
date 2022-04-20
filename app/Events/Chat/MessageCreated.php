<?php

namespace App\Events\Chat;

use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
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
        if ($room = $this->message->room) {
            $channels[] = new PrivateChannel('rooms.' . $room->getKey());

            /** @var User[] $users */
            $users = $room->users;
            foreach ($users as $user) {
                $user->unreadMessages()->attach($this->message->getKey(), ['is_seen' => $this->message->user_id === $user->getKey()]);
                $channels[] = new PrivateChannel('users.' . $user->getKey());
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
        return 'message.created';
    }
}
