<?php

namespace App\Policies\Placement;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterviewQuestionPolicy
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
}
