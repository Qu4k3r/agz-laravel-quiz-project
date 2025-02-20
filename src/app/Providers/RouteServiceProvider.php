<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    private const MAX_ATTEMPTS = 60;

    protected $namespace = 'App\Http\Controllers';

    private array $apiRouteFiles = [
        'api',
        'subject',
        'question',
        'alternative',
        'student',
        'quiz',
    ];

    protected function mapApiRoutes(): void
    {
        foreach ($this->apiRouteFiles as $filename) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path("routes/$filename.php"));
        }
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mapApiRoutes();
        $this->configureRateLimiting();

        $this->routes(function () {
//            Route::middleware('api')
//                ->prefix('api')
//                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(self::MAX_ATTEMPTS)->by($request->user()?->id ?: $request->ip());
        });
    }
}
