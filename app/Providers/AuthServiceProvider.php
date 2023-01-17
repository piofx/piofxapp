<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\EloquentUserProvider;
use App\Providers\UserProviderDecorator;
use Illuminate\Contracts\Cache\Repository;

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
        'App\Models\Core\Call' => 'App\Policies\Core\CallPolicy',
        'App\Models\Core\Client' => 'App\Policies\Core\ClientPolicy',
        'App\Models\Core\Contact' => 'App\Policies\Core\ContactPolicy',
        'App\Models\User' => 'App\Policies\Core\UserPolicy',

        // Loyalty Policies
        'App\Models\Loyalty\Customer' => 'App\Policies\Loyalty\CustomerPolicy',
        'App\Models\Loyalty\Reward' => 'App\Policies\Loyalty\RewardPolicy',

        // Blog Policies
        'App\Models\Blog\Post' => 'App\Policies\Blog\PostPolicy',
        'App\Models\Blog\Category' => 'App\Policies\Blog\CategoryPolicy',
        'App\Models\Blog\Tag' => 'App\Policies\Blog\TagPolicy',

        // Template Policy
        'App\Models\Template\Template' => 'App\Policies\Template\TemplatePolicy',
        'App\Models\Template\TemplateCategory' => 'App\Policies\Template\TemplateCategoryPolicy',
        'App\Models\Template\TemplateTag' => 'App\Policies\Template\TemplateTagPolicy',

        // Mailer Policy
        'App\Models\Mailer\MailCampaign' => 'App\Policies\Mailer\MailCampaignPolicy',
        'App\Models\Mailer\MailSubscriber' => 'App\Policies\Mailer\MailSubscriberPolicy',
        'App\Models\Mailer\MailTemplate' => 'App\Policies\Mailer\MailTemplatePolicy',
        'App\Models\Mailer\MailLog' => 'App\Policies\Mailer\MailLogPolicy',

        /* page policies */
        'App\Models\Page\Page' => 'App\Policies\Page\PagePolicy',
        'App\Models\Page\Theme' => 'App\Policies\Page\ThemePolicy',
        'App\Models\Page\Module' => 'App\Policies\Page\ModulePolicy',
        'App\Models\Page\Asset' => 'App\Policies\Page\AssetPolicy',

        /* college policies */
        'App\Models\College\College' => 'App\Policies\College\CollegePolicy',
        

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('cached', function ($app, array $config) {
            $provider = new EloquentUserProvider($app['hash'], $config['model']);
            $cache = $app->make(Repository::class);
            return new UserProviderDecorator($provider, $cache);
        });

    }
}
