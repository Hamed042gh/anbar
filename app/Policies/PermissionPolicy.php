<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('permission.view');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('permission.view');
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('permission.create');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('permission.edit');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('permission.delete');
    }

    public function restore(User $user, Permission $permission): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->isSuperAdmin();
    }
}
