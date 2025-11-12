<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator; // ← Importar el Paginator correcto de Laravel

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Usar Bootstrap para la paginación
        Paginator::useBootstrap();
        
        // Configuración para MySQL (opcional en versiones modernas de Laravel)
        if (config('database.default') === 'mysql') {
            Schema::defaultStringLength(191);
        }
    }
}