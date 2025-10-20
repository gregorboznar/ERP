<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('ViewAny:Role');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('View:Role');
    }

    public function create(User $user): bool
    {
        return $user->can('Create:Role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('Update:Role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('Delete:Role');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('Delete:Role');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->can('ForceDelete:Role');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('ForceDeleteAny:Role');
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->can('Restore:Role');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('RestoreAny:Role');
    }

    public function replicate(User $user, Role $role): bool
    {
        return $user->can('Replicate:Role');
    }

    public function reorder(User $user): bool
    {
        return $user->can('Reorder:Role');
    }
}
