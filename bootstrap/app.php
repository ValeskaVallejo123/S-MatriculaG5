<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'verificar.permiso'  => \App\Http\Middleware\VerificarPermiso::class,
            'verificar.rol'      => \App\Http\Middleware\VerificarRol::class,
            'rol'                => \App\Http\Middleware\VerificarRol::class,
            'role'               => \App\Http\Middleware\RoleMiddleware::class,
            'es.padre'           => \App\Http\Middleware\EsPadre::class,
            'forzar.contrasenia' => \App\Http\Middleware\ForzarCambioContrasenia::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();