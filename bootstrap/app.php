<?php

use App\Http\Middleware\AdminAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (){
            Route::middleware(['web', AdminAuthenticated::class, 'auth'])
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('/routes/web/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
    //    ValidateCsrfToken::except('payment/callback');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();
    