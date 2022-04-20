<?php

namespace App\Listeners\Account;

use App\Models\User;
use App\Notifications\Account\AccountCreated;

class SendAccountCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Account\AccountCreated $event
     * @return void
     */
    public function handle(\App\Events\Account\AccountCreated $event)
    {
        /** @var User $user */
        $user = $event->user;
        if($user){
            $user->notify(new AccountCreated($user, $event->password));
        }
    }
}
