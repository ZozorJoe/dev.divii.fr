<?php

namespace App\Policies\Catalog;

use App\Models\User;
use App\Policies\BasePolicy;

class DisciplinePolicy extends BasePolicy
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
}
