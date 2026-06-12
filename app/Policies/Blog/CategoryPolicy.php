<?php

namespace App\Policies\Blog;

use App\Models\Blog\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function view(User $user, Category $category)
    {
        if(($category->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmanager','clientmoderator'])))
            return true;
        elseif(($category->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
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
    public function create(User $user, Category $category)
    {
        return true;
    }

    /**
     * Determine if the given category can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\category  $category
     * @return bool
     */
    public function edit(User $user,Category $category)
    { 
       if(($category->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmanager','clientmoderator']))){

            if($user->checkRole(['clientadmin','clientmanager','clientmoderator']) && $user->id == $category->user_id)
                return true;
            else if($user->checkRole(['clientadmin','clientmanager','clientmoderator'])  && !$category->user_id)
                return true;
            else
                return false;
       }
        elseif(($category->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        if(($category->client_id == $user->client_id) && ($user->checkRole(['clientadmin','clientdeveloper','clientmanager','clientmoderator']))){

            if($user->checkRole(['clientadmin','clientmanager','clientmoderator']) && $user->id == $category->user_id)
                return true;
            else if($user->checkRole(['clientadmin','clientmanager','clientmoderator'])  && !$category->user_id)
                return true;
            else
                return false;
       }
        elseif(($category->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin','agencydev','agencymanager','agencymoderator'])))
            return true;
        elseif($user->checkRole(['superadmin','superdeveloper']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        if(($category->client_id == $user->client_id) && ($user->checkRole(['clientadmin']))){

            return true;
       }
        elseif(($category->agency_id == $user->agency_id) && ($user->checkRole(['agencyadmin'])))
            return true;
        elseif($user->checkRole(['superadmin']))
            return true;

        return false;
    }

    public function before(User $user, $ability)
    {
        if($user->checkRole(['superadmin','agencyadmin','clientadmin'])){
          
            return true;
        }
    }
}
