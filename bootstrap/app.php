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

        // Alias para middlewares personalizados
        $middleware->alias([
            'verificar.permiso' => \App\Http\Middleware\VerificarPermiso::class,
            'verificar.rol'     => \App\Http\Middleware\VerificarRol::class,
        ]);

        // Si luego necesitas middleware global:
        // $middleware->append(\App\Http\Middleware\Nombre::class);

        // O grupo: web / api
        // $middleware->appendToGroup('web', \App\Http\Middleware\AlgoMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Aquí puedes manejar errores personalizados
        // Ejemplo:
        // $exceptions->render(function (\Throwable $e) {
        //     return response()->view('errors.500', [], 500);
        // });
    })
    ->withMiddleware(function (Middleware $middleware) {

    // Alias para middlewares personalizados
    $middleware->alias([
        'verificar.permiso' => \App\Http\Middleware\VerificarPermiso::class,
        'verificar.rol'     => \App\Http\Middleware\VerificarRol::class,

        // ✅ ESTE ES EL QUE FALTABA
        'role'              => \App\Http\Middleware\RoleMiddleware::class,
    ]);

})

    ->create();
