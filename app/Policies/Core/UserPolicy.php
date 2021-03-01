<?php

namespace App\Policies\Core;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
     /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function viewAny(User $user,User $u)
    {

        return $user->checkRole(['superadmin','superdeveloper','agencyadmin','agencydeveloper','clientadmin','clientdeveloper', 'clientmanager', 'clientmoderator']);
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function view(User $user,User $u)
    {
       if(($u->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper'])))
            return true;
        elseif(($u->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function create(User $user,User $u)
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
    public function edit(User $user,User $u)
    { 
       if(($u->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper'])))
            return true;
        elseif(($u->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user,User $u)
    { 

        if(($u->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper'])))
            return true;
        elseif(($u->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }


    public function before(User $user, $ability)
    {
        if($user->isRole('superadmin'))
            return true;
    }
}
