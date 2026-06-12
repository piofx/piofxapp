<?php

namespace App\Policies\Core;

use App\Models\User;
use App\Models\Core\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
     public function view(User $user,Client $client)
    {
       return true;
       if(($client->id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($client->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
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
    public function create(User $user,Client $client)
    { 
        
        return true;
       if(($client->id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($client->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
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
    public function edit(User $user,Client $client)
    { 
       if(($client->id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($client->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
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
    public function update(User $user,Client $client)
    { 

        if(($client->id == $user->client_id) && ($user->checkRole(['clientadmin','clientdev'])))
            return true;
        elseif(($client->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev'])))
            return true;
        elseif($user->checkRole(['superadmin','superdev']))
            return true;

        return false;
    }


    public function before($user, $ability)
    {
       
        if($user->isRole('superadmin'))
            return true;
    }
}
