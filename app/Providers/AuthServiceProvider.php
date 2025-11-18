<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        // Gate para gestionar calendario
        Gate::define('gestionar-calendario', function ($user) {
            // Verifica si el user_type es 'super_admin'
            return $user->user_type === 'super_admin';
        });
    }
}