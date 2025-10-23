<?php

use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware): void {
        $middleware->alias([
            'role' => Spatie\Permission\Middlewares\RoleMiddleware::class,
            'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
            'role_or_permission' => Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function ($exceptions): void {
        //
    })->create();
