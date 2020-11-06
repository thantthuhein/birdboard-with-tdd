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
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();

            $this->mapWebRoutes();

            $this->mapProjectRoutes();
            
            $this->mapInvitationRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }

    /**
     * Define the "web" routes for the application.
     * 
     * @return void
     */
    protected function mapWebRoutes() {        
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
    
    /**
     * Define the "api" routes for the application.
     * 
     * @return void
     */
    protected function mapApiRoutes() {        
        Route::prefix('api')
            ->namespace($this->namespace)
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "user" routes for the application.
     * 
     * @return void
     */
    // protected function mapUserRoutes() {        
    //     $files = glob(base_path('routes/user/*.php'));
        
    //     foreach ($files as $file) {
    //         Route::middleware('web')
    //             ->namespace($this->namespace)
    //             ->group($file);
    //     }
    // }

    /**
     * Define the "project" routes for the application.
     * 
     * @return void
     */
    protected function mapProjectRoutes() {                
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth/project.php'));
    }

    /**
     * Define the "project" routes for the application.
     * 
     * @return void
     */
    protected function mapInvitationRoutes() {                
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth/invitation.php'));
    }
}
