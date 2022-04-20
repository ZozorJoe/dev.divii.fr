<?php

namespace App\Policies\Chat;

use App\Models\User;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class RoomPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function view(User $user, Model $model): bool
    {
        $user = $user->canJoin($model->getKey());
        return !is_null($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function update(User $user, Model $model): bool
    {
        if($user->isAdministrator()){
            return true;
        }

        $user = $user->canJoin($model->getKey());
        return !is_null($user);
    }
}
