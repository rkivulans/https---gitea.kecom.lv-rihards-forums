<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;

class ForumPostPolicy
{

    public function adminAny(User $user): bool
    {
        return $user->admin === "admin";
    }
}
