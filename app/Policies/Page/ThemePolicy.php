<?php

namespace App\Policies\Page;

use App\Models\User;
use App\Models\Page\Theme;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
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
     public function viewAny(User $user,Theme $theme)
    {
        if($user->checkRole(['superadmin','superdev','agencyadmin','agencydev','clientadmin','clientdev']))
            return true;

        return false;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function view(User $user,Theme $theme)
    {

       if(($theme->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($theme->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
            return true;
        elseif($user->checkRole(['superadmin','superdev']))
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
    public function create(User $user,Theme $theme)
    { 
       if($user->checkRole(['superadmin','superdev','agencyadmin','agencydev','clientadmin','clientdev']))
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
    public function edit(User $user,Theme $theme)
    { 
       if(($theme->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($theme->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
            return true;
        elseif($user->checkRole(['superadmin','superdev']))
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
    public function update(User $user,Theme $theme)
    { 

        if(($theme->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($theme->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
            return true;
        elseif($user->checkRole(['superadmin','superdev']))
            return true;

        return false;
    }


    public function before(User $user, $ability)
    {
        if($user->isRole('superadmin'))
            return true;
    }
}
