<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;

class LikePolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->id !== null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Like $like): bool
    {
        return $user->id === $like->user_id;
    }

}
