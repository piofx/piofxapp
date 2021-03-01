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

        return $user->isRole('siteadmin') || $user->isRole('superadmin') ;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function view(User $user,Contact $contact)
    {

        if($user->client_id == $contact->client_id) // to check if the contact form is from his site
            if($user->isRole('siteadmin')) // he has authority  to open it
                return true;
            else 
                return false;
        else
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
       if($user->client_id == $contact->client_id) // to check if the contact form is from his site
            if($user->isRole('siteadmin')) // he has authority  to open it
                return true;
            else 
                return false;
        else
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

        if($user->client_id == $contact->client_id) // to check if the contact form is from his site
            if($user->isRole('siteadmin')) // he has authority  to open it
                return true;
            else 
                return false;
        else
            return false;
    }


    public function before(User $user, $ability)
    {
        if($user->isRole('superadmin'))
            return true;
    }
}
