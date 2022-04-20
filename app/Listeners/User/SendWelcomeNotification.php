<?php

namespace App\Listeners\User;

use App\Events\Auth\Registered;
use App\Models\User;
use App\Notifications\User\Welcome;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendWelcomeNotification
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if (!$event->user instanceof MustVerifyEmail || $event->user->hasVerifiedEmail()) {
            /** @var User $user */
            $user = $event->user;
            if($user){
                $user->notify(new Welcome());
            }
        }
    }
}
