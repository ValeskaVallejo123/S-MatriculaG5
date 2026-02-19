<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Deshabilitar foreign key constraints al eliminar tablas
        if (config('database.default') === 'mysql') {
            Schema::defaultStringLength(191);
        }
    }
}