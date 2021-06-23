<?php

namespace App\Policies;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhoneNumberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return mixed
     */
    public function view(User $user, PhoneNumber $phoneNumber)
    {
        if ($phoneNumber->shared_user_ids == null) $phoneNumber->shared_user_ids = '[]';

        return ($user->id === $phoneNumber->user_id) || (in_array($user->id, json_decode($phoneNumber->shared_user_ids)));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return mixed
     */
    public function update(User $user, PhoneNumber $phoneNumber)
    {
        return ($user->id === $phoneNumber->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return mixed
     */
    public function delete(User $user, PhoneNumber $phoneNumber)
    {
        return ($user->id === $phoneNumber->user_id);
    }

    /**
     * Determine whether the user can share the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return mixed
     */
    public function share(User $user, PhoneNumber $phoneNumber)
    {
        return ($user->id === $phoneNumber->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return mixed
     */
    public function restore(User $user, PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return mixed
     */
    public function forceDelete(User $user, PhoneNumber $phoneNumber)
    {
        //
    }
}
