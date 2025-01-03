<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\VerifyCsrfHeader; // Import your custom CSRF middleware
use App\Http\Middleware\VerifySessionHeader; // Import your custom Session middleware
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            // Optional: Add any exceptions if needed
        ]);

        // $middleware->append(EnsureFrontendRequestsAreStateful::class);
        // $middleware->append(SubstituteBindings::class);
        $middleware->append(CorsMiddleware::class);
        $middleware->append(VerifyCsrfToken::class);

        
        $middleware->append(StartSession::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
