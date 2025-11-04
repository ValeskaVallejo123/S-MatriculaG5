<?php

namespace App\Http;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware asignables a rutas específicas.
     */
    protected $routeMiddleware = [
       
        'rol' => \App\Http\Middleware\RolMiddleware::class,
    ];
}
