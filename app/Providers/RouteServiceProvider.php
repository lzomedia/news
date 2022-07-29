<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';


    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(
            function () {
                Route::prefix('api')
                    ->group(base_path('routes/api.php'));

                Route::middleware('web')
                ->group(base_path('routes/web.php'));
            }
        );
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
//        RateLimiter::for(
//            'api',
//            static function (Request $request) {
//                $userID = (string) $request->user()?->id;
//
//                $ip = (string) $request->ip();
//
//                return Limit::perMinute(60)->by($userID ?: $ip);
//            }
//        );
        RateLimiter::for('articles', static function (Request $request) {
            return Limit::none();
        });

    }
}
