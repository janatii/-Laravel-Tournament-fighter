<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UsersPolicy::class,
        \App\Models\Platform::class => \App\Policies\PlatformsPolicy::class,
        \App\Models\Game::class => \App\Policies\GamesPolicy::class,
        \App\Models\Network::class => \App\Policies\NetworksPolicy::class,
        \App\Models\Team::class => \App\Policies\TeamsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (\App\Models\User $user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
