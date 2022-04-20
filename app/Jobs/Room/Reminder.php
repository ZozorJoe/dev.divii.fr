<?php

namespace App\Jobs\Room;

use App\Models\Chat\Room;
use App\Models\User;
use App\Notifications\Room\Reminder24h;
use App\Notifications\Room\Reminder30m;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Reminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var Room
     */
    protected $room;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Room $room, User $user, $time)
    {
        $this->room = $room;
        $this->user = $user;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->time){
            case 24 * 3600:
                $notification = new Reminder24h($this->room, $this->time);
                $this->user->notify($notification);
            break;
            case 30:
                $notification = new Reminder30m($this->room, $this->time);
                $this->user->notify($notification);
            break;
        }
    }
}
