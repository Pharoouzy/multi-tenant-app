<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        //
        // Passport::routes();

        \Laravel\Passport\Passport::routes(null, ['middleware' => 'tenancy.enforce']);

        $this->commands([
            \Laravel\Passport\Console\InstallCommand::class,
            \Laravel\Passport\Console\ClientCommand::class,
            \Laravel\Passport\Console\KeysCommand::class,
        ]);

        \Laravel\Passport\Passport::tokensExpireIn(\Carbon\Carbon::now()->addMinutes(10));
        \Laravel\Passport\Passport::refreshTokensExpireIn(\Carbon\Carbon::now()->addDays(1));
    }
}
