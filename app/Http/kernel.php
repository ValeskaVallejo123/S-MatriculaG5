<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'rol' => \App\Http\Middleware\RolMiddleware::class,
    ];
   protected $middlewareAliases = [
    // ... otros middleware
    'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
];
}