<?php

namespace App\Policies;


use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Check permmission for create user.
     *
     * @return mixed
     */
    public function createUser(User $user)
    {
        return $user->role == 'manager';
    }

    /**
     * Check permmission for create post.
     *
     * @return mixed
     */
    public function createPost(User $user)
    {
        return $user->role == 'employee';
    }


}
