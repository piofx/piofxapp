<?php

namespace App\Policies\Loyalty;

use App\Models\Loyalty\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
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
        return $user->checkRole(['superadmin','superdeveloper','agencyadmin','agencydeveloper','agencymoderator','clientadmin','clientdeveloper', 'clientmanager', 'clientmoderator']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loyalty\Customer  $customer
     * @return mixed
     */
    public function view(User $user, Customer $customer)
    {
        return $user->checkRole(['superadmin','superdeveloper','agencyadmin','agencydeveloper','agencymoderator','clientadmin','clientdeveloper', 'clientmanager', 'clientmoderator']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkRole(['superadmin','superdeveloper','agencyadmin','agencydeveloper','clientadmin','clientdeveloper', 'clientmanager', 'clientmoderator']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loyalty\Customer  $customer
     * @return mixed
     */
    public function update(User $user, Customer $customer)
    {
        if(($customer->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper'])))
            return true;
        elseif(($customer->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;
        elseif(($user->client_id == $customer->client_id) && ($user->id == $customer->user_id))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loyalty\Customer  $customer
     * @return mixed
     */
    public function delete(User $user, Customer $customer)
    {
        if(($customer->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper'])))
            return true;
        elseif(($customer->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
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
