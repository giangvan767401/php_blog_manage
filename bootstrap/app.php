<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.admin' => AdminMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function ($response, $e, $request) {
            if ($response->getStatusCode() === 419) {
                return redirect()->route('login')->withErrors(['session' => 'Phiên làm việc đã hết hạn. Vui lòng đăng nhập lại.']);
            }
            return $response;
        });
    })->create();
