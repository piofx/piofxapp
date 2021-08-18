<?php

namespace App\Policies\Mailer;
use App\Models\Mailer\MailCampaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailCampaignPolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function view(User $user, MailCampaign $mailcampaign)
    {
        if($user->checkRole(['superadmin','agencyadmin','clientadmin']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user , MailCampaign $mailcampaign)
    {   
        if($user->checkRole(['superadmin','agencyadmin','clientadmin']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function update(User $user, MailCampaign $mailcampaign)
    {
        if($user->checkRole(['superadmin','agencyadmin','clientadmin']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function delete(User $user, MailCampaign $mailcampaign)
    {
        if($user->checkRole(['superadmin','agencyadmin','clientadmin']))
            return true;

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function edit(User $user, MailCampaign $mailcampaign)
    {
        if($user->checkRole(['superadmin','agencyadmin','clientadmin']))
            return true;

        return false;
    }

    public function resendmails(User $user, MailCampaign $mailcampaign)
    {
        if($user->checkRole(['superadmin']))
            return true;

        return false;
    }

    public function before(User $user, $ability)
    {
        if($user->isRole('superadmin','agencyadmin','clientadmin'))
            return true;
    }

}
