<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Deshabilitar foreign key constraints al eliminar tablas
        if (config('database.default') === 'mysql') {
            Schema::defaultStringLength(191);
        }

        Paginator::useBootstrap();
    }
}