<?php

namespace App\Policies\College;

use App\Models\User;
use App\Models\College\College;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollegePolicy
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
     * @param  \App\Models\Loyalty\College  $college
     * @return mixed
     */
    public function view(User $user, College $college)
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
     * @param  \App\Models\Loyalty\College  $college
     * @return mixed
     */
    public function update(User $user, College $college)
    {
        if(($college->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmoderator'])))
            return true;
        elseif(($college->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;
        elseif(($user->client_id == $college->client_id) && ($user->id == $college->user_id))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loyalty\College  $college
     * @return mixed
     */
    public function delete(User $user, College $college)
    {
        if(($college->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper'])))
            return true;
        elseif(($college->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydeveloper'])))
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
