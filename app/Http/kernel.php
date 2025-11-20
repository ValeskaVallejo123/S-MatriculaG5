<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'rol' => \App\Http\Middleware\RolMiddleware::class,
    
    ];
   protected $middlewareAliases = [
    // ... otros middlewares
    'admin' => \App\Http\Middleware\IsAdmin::class,
];

    protected $middlewareGroups = [
        'web' => [
            // ... middlewares del grupo web
        ],

        'api' => [
            // ... middlewares del grupo api
        ],
];
}