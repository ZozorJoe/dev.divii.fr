<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/**
 * @var User $user
 */
Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('rooms.{roomId}', function ($user, $roomId) {
    return $user->canJoin($roomId);
});

Broadcast::channel('rooms.{roomId}.{userId}', function ($user, $roomId, $userId) {
    return ((int) $user->getKey() === (int) $userId) && $user->canJoin($roomId);
});
