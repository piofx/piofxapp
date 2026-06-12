<?php

namespace App\Policies\Blog;

use App\Models\Blog\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
        if($user->checkRole(['superadmin','superdeveloper','agencyadmin','agencydev','clientadmin','clientdeveloper','clientmanager','clientmoderator']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        if(($post->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmanager','clientmoderator'])))
            return true;
        elseif(($post->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Post $post)
    {
        return true;
    }

    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Post $post)
    { 
       if(($post->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmanager','clientmoderator']))){

            if($user->checkRole(['clientadmin','clientmanager','clientmoderator']) && $user->id == $post->user_id)
                return true;
            else if($user->checkRole(['clientadmin','clientmanager','clientmoderator'])  && !$post->user_id)
                return true;
            else
                return false;
       }
        elseif(($post->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        if(($post->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmanager','clientmoderator']))){

            if($user->checkRole(['clientadmin','clientmanager','clientmoderator']) && $user->id == $post->user_id)
                return true;
            else if($user->checkRole(['clientadmin','clientmanager','clientmoderator'])  && !$post->user_id)
                return true;
            else
                return false;
       }
        elseif(($post->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        if(($post->client_id == $user->client_id) && ($user->checkRole(['clientadmin']))){

            return true;
       }
        elseif(($post->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin'])))
            return true;
        elseif($user->checkRole(['superadmin']))
            return true;

        return false;
    }

    public function before(User $user, $ability)
    {
        if($user->checkRole(['superadmin','agencyadmin','clientadmin']))
            return true;
    }
}
