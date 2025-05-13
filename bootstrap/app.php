<?php

use App\Exceptions\ApiException;
use App\Exceptions\SpotifyException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'i18n' => \App\Http\Middleware\i18nMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e) {
            return response()->json([
                'error' => true,
                'message' => __('i18n.authentication_error')
            ], 401);
        });

        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'error' => true,
                'errors' => $e->errors(),
                'message' => __('i18n.validation_error'),
            ], 422);
        });


        $exceptions->render(function (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => __('i18n.unexpected_error'),
            ], 500);
        });
    })->create();
