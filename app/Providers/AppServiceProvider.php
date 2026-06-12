<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mail::macro('setConfig', function (string $key, string $domain) {

            config()->set('services', array_merge(config('services'), [
            'mailgun' => [
                'domain' => $domain,
                'secret' => $key
            ]
        ]));
            return $this;
        });
        Paginator::useBootstrap();
    }
}
