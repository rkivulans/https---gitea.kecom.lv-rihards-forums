<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Music;
use Illuminate\Auth\Access\HandlesAuthorization;

class MusicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any music tracks.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view a music track.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Music  $music
     * @return bool
     */
    public function view(User $user, Music $music)
    {
        return true;
    }

    /**
     * Determine whether the user can create a new music track.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->admin; // Only allow users with admin privileges to create music
    }

    /**
     * Determine whether the user can update a music track.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Music  $music
     * @return bool
     */
    public function update(User $user, Music $music)
    {
        return $user->admin; // Only allow admins to update music
    }

    /**
     * Determine whether the user can delete a music track.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Music  $music
     * @return bool
     */
    public function delete(User $user, Music $music)
    {
        return $user->admin; // Only allow admins to delete music
    }
}
