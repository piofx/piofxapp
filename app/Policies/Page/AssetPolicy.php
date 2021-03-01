<?php

namespace App\Policies\Page;

use App\Models\User;
use App\Models\Page\Asset;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
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
     public function viewAny(User $user,Asset $asset)
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
     public function view(User $user,Asset $asset)
    {

       if(($asset->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($asset->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
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
    public function create(User $user,Asset $asset)
    { 
        return $user->checkRole(['superadmin','superdev','agencyadmin','agencydev','clientadmin','clientdev']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Asset $asset)
    { 
       if(($asset->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($asset->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
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
    public function update(User $user,Asset $asset)
    { 

        if(($asset->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($asset->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
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
