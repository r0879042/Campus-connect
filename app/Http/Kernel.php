<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global middleware (run on every request).
     * Keep empty for now to avoid missing-class errors.
     */
    protected $middleware = [
        // You can add \Illuminate\Http\Middleware\HandleCors::class later if needed.
    ];

    /**
     * Middleware groups.
     * Keep these small and only use classes that certainly exist.
     */
    protected $middlewareGroups = [
        'web' => [
            // Sessions + errors + route model binding (framework-provided)
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Add CSRF later when your VerifyCsrfToken class exists:
            // \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // throttle can be added later if you want:
            // \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
        ],
    ];

    /**
     * Route middleware aliases (used in routes).
     */
    protected $middlewareAliases = [
        // If you have app/Http/Middleware/Authenticate.php, use that:
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,

        // Your role middleware (make sure this file exists)
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}
