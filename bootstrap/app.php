<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware; // ← tambahkan ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
    $middleware->web(); // aktifkan CSRF, session, dll

    // daftar custom middleware kamu juga boleh disini
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'ensureUserHasRole' => \App\Http\Middleware\EnsureUserHasRole::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
