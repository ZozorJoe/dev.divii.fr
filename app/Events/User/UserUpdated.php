<?php

namespace App\Events\User;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The authenticated user.
     *
     * @var Authenticatable
     */
    public $user;

    /**
     * @var mixed|null
     */
    public $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Authenticatable $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
