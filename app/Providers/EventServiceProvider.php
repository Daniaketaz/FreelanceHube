<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        \App\Events\UserAuthenticated::class => [
            \App\Listeners\CreateUserSessionListener::class,
        ],
        \App\Events\UserLoggedOut::class => [
            \App\Listeners\RevokeSessionListener::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
