<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Assignment;
use App\Models\User;

class AssignmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Assignment');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        return $user->checkPermissionTo('view Assignment');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Assignment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        return $user->checkPermissionTo('update Assignment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->checkPermissionTo('delete Assignment');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return $user->checkPermissionTo('restore Assignment');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return $user->checkPermissionTo('force-delete Assignment');
    }
}
