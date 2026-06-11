<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->alias([
        'dormhead' => \App\Http\Middleware\DormHeadOnly::class,
    ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'tenant.active' => \App\Http\Middleware\CheckTenantActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please wait 1 minute and try again.',
            ])->withInput($request->only('email'));
        });

        $exceptions->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            return redirect('/login')->withErrors([
                'email' => 'Your session expired. Please try logging in again.',
            ]);
        });
    })->create();