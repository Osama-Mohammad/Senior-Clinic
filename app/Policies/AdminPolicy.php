<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Admin $user, Admin $admin): bool
    {
        return $user && $user->id === $admin->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Admin $user, Admin $admin): bool
    {
        return $user && $user->id === $admin->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view their own profile.
     */
    public function AdminProfile(?Admin $currentAdmin, Admin $profileAdmin): bool
    {
        return $currentAdmin && $currentAdmin->id === $profileAdmin->id;
    }
}
