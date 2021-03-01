<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',

        /* core policies */
        'App\Models\Core\Admin' => 'App\Policies\Core\AdminPolicy',
        'App\Models\Core\Agency' => 'App\Policies\Core\AgencyPolicy',
        'App\Models\Core\Client' => 'App\Policies\Core\ClientPolicy',
        'App\Models\Core\Contact' => 'App\Policies\Core\ContactPolicy',
        'App\Models\User' => 'App\Policies\Core\UserPolicy',

        // Loyalty Policies
        'App\Models\Loyalty\Customer' => 'App\Policies\Loyalty\CustomerPolicy',
        'App\Models\Loyalty\Reward' => 'App\Policies\Loyalty\RewardPolicy',

        /* page policies */
        'App\Models\Page\Page' => 'App\Policies\Page\PagePolicy',
        'App\Models\Page\Theme' => 'App\Policies\Page\ThemePolicy',
        'App\Models\Page\Module' => 'App\Policies\Page\ModulePolicy',
        'App\Models\Page\Asset' => 'App\Policies\Page\AssetPolicy',
        

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
