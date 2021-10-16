<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $ategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Category $Category)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isRole('EMPLOYER');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Category $Category)
    {
        return $user->isRole('EMPLOYER');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\odel=Category  $odel=Category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Category $Category)
    {
        return $user->isRole('ADMIN');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Category $Category)
    {
        return $user->isRole('ADMIN');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user,Category $Category)
    {
        return $user->isRole('ADMIN');
    }
}
