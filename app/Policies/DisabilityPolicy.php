<?php

namespace App\Policies;

use App\Models\Disability;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class DisabilityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  true;
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Disability $disability): bool
    {
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin" || $disability->user_profile_id==$user->profile->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin" || Auth::user()->id==$user->profile->user_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Disability $disability): bool
    {
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin" || $disability->user_profile_id==$user->profile->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Disability $disability): bool
    {
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin" || $disability->user_profile_id==$user->profile->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Disability $disability): bool
    {
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin" || $disability->user_profile_id==$user->profile->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Disability $disability): bool
    {
        return ($user->role->name=="Admin" || $user->role->name=="SuperAdmin" || $disability->user_profile_id==$user->profile->id);
    }
}
