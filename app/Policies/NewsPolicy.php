<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->canPost();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news)
    {
        return $user->id === $news->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news)
    {
        return $user->id === $news->user_id || $user->isAdmin();
    }
}
