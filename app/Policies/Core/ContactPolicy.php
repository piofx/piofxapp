<?php

namespace App\Policies\Core;

use App\Models\User;
use App\Models\Core\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
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
     public function viewAny(User $user,Contact $contact)
    {

         if($user->checkRole(['superadmin','superdeveloper','agencyadmin','agencydev','clientadmin','clientmanager','clientmoderator']))
            return true;

        return false;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function view(User $user,Contact $contact)
    {

        if(($contact->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientmanager','clientmoderator'])))
            return true;
        elseif(($contact->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
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
    public function create(User $user,Contact $contact)
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
    public function edit(User $user,Contact $contact)
    { 
       if(($contact->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientmanager','clientmoderator']))){

            if($user->checkRole(['clientadmin','clientmanager','clientmoderator']) && $user->id == $contact->user_id)
                return true;
            else if($user->checkRole(['clientadmin','clientmanager','clientmoderator'])  && !$contact->user_id)
                return true;
            else
                return false;
       }
        elseif(($contact->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
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
    public function update(User $user,Contact $contact)
    { 

        if(($contact->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientmanager','clientmoderator']))){

            if($user->checkRole(['clientadmin','clientmanager','clientmoderator']) && $user->id == $contact->user_id)
                return true;
            else if($user->checkRole(['clientadmin','clientmanager','clientmoderator'])  && !$contact->user_id)
                return true;
            else
                return false;
       }
        elseif(($contact->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

       /**
     * Determine if the given post can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function delete(User $user,Contact $contact)
    { 

        if(($contact->client_id == $user->client_id) && ($user->checkRole(['clientadmin']))){

            return true;
       }
        elseif(($contact->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin'])))
            return true;
        elseif($user->checkRole(['superadmin']))
            return true;

        return false;
    }


    public function before(User $user, $ability)
    {
        if($user->isRole('superadmin','agencyadmin','clientadmin'))
            return true;
    }
}
