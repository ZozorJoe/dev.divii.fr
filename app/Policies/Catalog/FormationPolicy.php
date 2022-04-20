<?php

namespace App\Policies\Catalog;

use App\Models\User;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class FormationPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdministrator() || $user->isExpert();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function view(User $user, Model $model)
    {
        return $user->isAdministrator() || ($user->isExpert() && ((int) $user->id === (int) $model->user_id));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->isAdministrator() || $user->isExpert();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function update(User $user, Model $model)
    {
        return $user->isAdministrator() || ($user->isExpert() && ((int) $user->id === (int) $model->user_id));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function delete(User $user, Model $model)
    {
        return $user->isAdministrator() || ($user->isExpert() && ((int) $user->id === (int) $model->user_id));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function restore(User $user, Model $model)
    {
        return $user->isAdministrator() || ($user->isExpert() && ((int) $user->id === (int) $model->user_id));
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function forceDelete(User $user, Model $model)
    {
        return $user->isAdministrator() || ($user->isExpert() && ((int) $user->id === (int) $model->user_id));
    }
}
