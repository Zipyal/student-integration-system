<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model)
    {
        return $user->isAdmin() || 
               ($user->isCurator() && $model->curator_id === $user->id);
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model)
    {
        return $user->isAdmin() || 
               ($user->isCurator() && $model->curator_id === $user->id);
    }

    public function delete(User $user, User $model)
    {
        return $user->isAdmin();
    }
}