<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapUsersRoutes(); 
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapUsersRoutes()
    {
        foreach (glob(base_path('routes/users/*.php')) as $file) {
            $folder = explode('/', $file);
            print_r($this->namespace . '\\' . explode('.', $folder[count($folder) - 1])[0]);

            // if(explode('.', $folder[count($folder) - 1])[0] == 'PRP' || explode('.', $folder[count($folder) - 1])[0] == 'prp') {
            //     dd($this->namespace . '\\' . explode('.', $folder[count($folder) - 1])[0] );
            // }
            Route::middleware('web')
                ->namespace($this->namespace . '\\' . explode('.', $folder[count($folder) - 1])[0] )
                ->group($file);
        }
    }
}
