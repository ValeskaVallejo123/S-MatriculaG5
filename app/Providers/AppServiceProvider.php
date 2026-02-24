<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
=======
use Illuminate\Support\Facades\Schema; // <--- Importar esto
>>>>>>> origin/josue_matriculag5

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
<<<<<<< HEAD
        // Deshabilitar foreign key constraints al eliminar tablas
        if (config('database.default') === 'mysql') {
            Schema::defaultStringLength(191);
        }

        Paginator::useBootstrap();
=======
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Establecer la longitud predeterminada para índices de strings
        Schema::defaultStringLength(191); 
>>>>>>> origin/josue_matriculag5
    }
}