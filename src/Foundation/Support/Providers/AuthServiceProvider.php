<?php

namespace Moneo\Authorization\Foundation\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Moneo\Authorization\Support\Facades\Gate;
use Moneo\Authorization\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return $this->policies;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared(GateContract::class, function ($app) {
            return new \Moneo\Authorization\Auth\Access\Gate($app, [$this, 'getUser']);
        });
    }
}
