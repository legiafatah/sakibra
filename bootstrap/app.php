<?php

use App\Http\Middleware\SuperadminAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // ✅ Tambahkan ini
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'SuperadminAuth' => \App\Http\Middleware\SuperadminAuth::class,
            'PesertaAuth' => \App\Http\Middleware\PesertaAuth::class,
            'AdminAuth' => \App\Http\Middleware\AdminAuth::class,
            'JuriAuth' => \App\Http\Middleware\JuriAuth::class,
            'GuestSuperadmin' => \App\Http\Middleware\GuestSuperadmin::class,
            'GuestPeserta' => \App\Http\Middleware\GuestPeserta::class,
            'GuestAdmin' => \App\Http\Middleware\GuestAdmin::class,
            'GuestJuri' => \App\Http\Middleware\GuestJuri::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
