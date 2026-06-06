<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('user.view');
    }

    public function view(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('user.view');
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('user.create');
    }

    public function update(User $user, User $model): bool
    {
        if ($model->isSuperAdmin() && !$user->isSuperAdmin()) {
            return false;
        }

        return $user->isSuperAdmin() || $user->hasPermissionTo('user.edit');
    }

    public function delete(User $user, User $model): bool
    {
        if ($model->isSuperAdmin()) {
            return false;
        }

        return $user->isSuperAdmin() || $user->hasPermissionTo('user.delete');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }
}
