<?php

namespace App\Http;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\RequirePassword;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\CheckRole;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  /**
   * The application's global HTTP middleware stack.
   *
   * @var array
   */
  protected $middleware = [
    // Other global middleware
  ];

  /**
   * The application's route middleware groups.
   *
   * @var array
   */
  protected $middlewareGroups = [

    'api' => [
      'throttle:api',
      SubstituteBindings::class,
    ],
  ];

  /**
   * The application's middleware aliases.
   *
   * @var array
   */
  protected $middlewareAliases = [
    'auth.basic' => AuthenticateWithBasicAuth::class,
    'auth.session' => AuthenticateSession::class,
    'cache.headers' => SetCacheHeaders::class,
    'can' => Authorize::class,
    'guest' => RedirectIfAuthenticated::class,
    'password.confirm' => RequirePassword::class,
    'signed' => ValidateSignature::class,
    'throttle' => ThrottleRequests::class,
    'verified' => EnsureEmailIsVerified::class,
    // GraphQL specific middleware
    'role' => CheckRole::class,
    'permission' => PermissionMiddleware::class,
    'role_or_permission' => RoleOrPermissionMiddleware::class,
  ];

  // Other configurations
}
