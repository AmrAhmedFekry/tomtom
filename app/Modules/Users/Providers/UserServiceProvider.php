<?php
namespace App\Modules\Users\Providers;

use Illuminate\Support\Facades\Route;
use HZ\Illuminate\Mongez\Managers\Providers\ModuleServiceProvider;

class UserServiceProvider extends ModuleServiceProvider
{
    /**
     * {@inheritDoc}
     */
    const ROUTES_TYPES = ["admin"];

    /**
     * {@inheritDoc}
     */
    protected $namespace = 'App/Modules/Users/';

    /**
     * {@inheritDoc}
     */
    public function mapApiRoutes()
    {
        foreach (static::ROUTES_TYPES as $routeType) {
            $routeFilePath = 'routes/admin.php';
            $routeFilePath = lcfirst($this->namespace) . $routeFilePath;
            Route::prefix('api/admin')
                ->middleware('admin')
                ->namespace('App')
                ->group(base_path($routeFilePath));
        }
    }

}
