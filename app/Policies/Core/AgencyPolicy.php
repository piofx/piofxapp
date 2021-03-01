<?php

namespace App\Policies\Core;

use App\Models\User;
use App\Models\Core\Agency;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
{
    use HandlesAuthorization;

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
     public function view(User $user,Agency $agency)
    {
       
        return $user->isRole('superadmin');
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function create(User $user,Agency $agency)
    { 
        
        return $user->isRole('superadmin');
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Agency $agency)
    { 
       return $user->isRole('superadmin');
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user,Agency $agency)
    { 

        return $user->isRole('superadmin');
    }


    public function before($user, $ability)
    {
       
        if($user->isRole('superadmin'))
            return true;
    }
}
