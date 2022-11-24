<?php

namespace App\Http;

use App\Http\Middleware\LinkMiddleware;
// User
use App\Http\Middleware\User\Delete as UserDelete;
use App\Http\Middleware\User\Insert as UserInsert;
use App\Http\Middleware\User\Update as UserUpdate;

// Family
use App\Http\Middleware\Family\Insert as FamilyInsert;
use App\Http\Middleware\Family\Update as FamilyUpdate;
use App\Http\Middleware\Family\Delete as FamilyDelete;

// Born
use App\Http\Middleware\Born\Insert as BornInsert;
use App\Http\Middleware\Born\Update as BornUpdate;
use App\Http\Middleware\Born\Delete as BornDelete;

// Comer
use App\Http\Middleware\Comer\Delete as ComerDelete;
use App\Http\Middleware\Comer\Insert as ComerInsert;
use App\Http\Middleware\Comer\Update as ComerUpdate;

// Dead
use App\Http\Middleware\Dead\Insert as DeadInsert;
use App\Http\Middleware\Dead\Update as DeadUpdate;
use App\Http\Middleware\Dead\Delete as DeadDelete;
use App\Http\Middleware\Family\Add;
// Move
use App\Http\Middleware\Move\Delete as MoveDelete;
use App\Http\Middleware\Move\Insert as MoveInsert;
use App\Http\Middleware\Move\Update as MoveUpdate;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
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
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'link' => LinkMiddleware::class,
        'UserInsert' => UserInsert::class,
        'UserUpdate' => UserUpdate::class,
        'UserDelete' => UserDelete::class,

        // family
        'FamilyInsert' => FamilyInsert::class,
        'FamilyUpdate' => FamilyUpdate::class,
        'FamilyDelete' => FamilyDelete::class,
        'FamilyAdd' => Add::class,

        // Born
        'BornInsert' => BornInsert::class,
        'BornUpdate' => BornUpdate::class,
        'BornDelete' => BornDelete::class,

        // Comer
        'ComerInsert' => ComerInsert::class,
        'ComerUpdate' => ComerUpdate::class,
        'ComerDelete' => ComerDelete::class,

        // Dead
        'DeadInsert' => DeadInsert::class,
        'DeadUpdate' => DeadUpdate::class,
        'DeadDelete' => DeadDelete::class,

        // Pindah
        'MoveInsert' => MoveInsert::class,
        'MoveUpdate' => MoveUpdate::class,
        'MoveDelete' => MoveDelete::class,
    ];
}
