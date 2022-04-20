<?php

namespace App\Events\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class Registered extends \Illuminate\Auth\Events\Registered
{
    /**
     * @var mixed|null
     */
    public $password;

    /**
     * Create a new event instance.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    public function __construct($user, $password = null)
    {
        parent::__construct($user);
        $this->password = $password;
    }
}
