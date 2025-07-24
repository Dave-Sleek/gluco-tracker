<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     * These run during every request to your application.
     */
    protected $middleware = [
        // Laravel's default middleware, like
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $commands = [
        \App\Console\Commands\SendPendingNotifications::class,
    ];
    

    /**
     * Route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route middleware (registered by alias).
     */
    protected $routeMiddleware = [
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified'   => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'is_admin'   => \App\Http\Middleware\IsAdmin::class, // ✅ Your custom admin middleware
    ];
}
