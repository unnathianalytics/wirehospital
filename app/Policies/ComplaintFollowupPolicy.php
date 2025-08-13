<?php

namespace App\Policies;

use App\Models\ComplaintFollowup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComplaintFollowupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ComplaintFollowup $complaintFollowup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ComplaintFollowup $complaintFollowup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ComplaintFollowup $complaintFollowup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ComplaintFollowup $complaintFollowup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ComplaintFollowup $complaintFollowup): bool
    {
        return false;
    }
}
